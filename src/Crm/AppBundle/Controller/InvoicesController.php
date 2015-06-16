<?php

namespace Crm\AppBundle\Controller;

use Crm\AppBundle\Entity\Invoice;
use Crm\AppBundle\Form\Type\InvoiceType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoicesController extends Controller
{
    /**
     * @var integer Page size.
     */
    const PAGE_SIZE = 10;

    /**
     * Action to show the list of invoices.
     *
     * @param Request $request The request object.
     * @param integer $page The current page.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, $page)
    {
        $date       = $request->request->get('date');
        $is_paid    = $request->request->get('is_paid');

        $filters = array(
            'date'      => empty($date)? date('Y-m'): $date,
            'is_paid'   => is_null($is_paid)? '': $is_paid,
        );

        $invoices = $this->getDoctrine()
            ->getRepository('CrmAppBundle:Invoice')
            ->getInvoicesList($filters, $page, self::PAGE_SIZE);

        return $this->render(
            'CrmAppBundle:Invoices:list.html.twig',
            array(
                'invoices'      => $invoices->getIterator(),
                'filters'       => $filters,
                'current_page'  => $page,
                'total_pages'   => ceil( $invoices->count() / self::PAGE_SIZE)
            )
        );
    }

    /**
     * Handle the show invoice action.
     *
     * @param integer $id Identifier of invoice
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $invoice    = $em->getRepository('CrmAppBundle:Invoice')->findOneById($id);

        return $this->render(
            'CrmAppBundle:Invoices:show.html.twig',
            array(
                'invoice'	        => $invoice,
                'invoice_totals'    => $this->calculateInvoiceTotalAmounts($invoice),
                'bank_account'      => $this->container->getParameter('bank_account'),
                'own_company'       => $this->container->getParameter('company'),
                'own_contact'       => $this->container->getParameter('contact'),
                'currency'          => $this->container->getParameter('currency'),
            )
        );
    }

    /**
     * Handle the new invoice action.
     *
     * @param Request $request
     * @param integer $id_company Identifier of company.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, $id_company)
    {
        $em = $this->getDoctrine()->getManager();
        $company    = $em->getRepository('CrmAppBundle:Company')->findOneById($id_company);
        $reference  = $em->getRepository('CrmAppBundle:Invoice')->getNextReferenceNumber();

        // create an invoice and give it some dummy data for this example
        $invoice = new Invoice();
        $invoice->setReference($reference);
        $invoice->setCompany($company);

        $form = $this->createForm(new InvoiceType(), $invoice);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the invoice to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('crm_app_company_show', array('id' => $id_company));
        }

        return $this->render(
            'CrmAppBundle:Invoices:edit.html.twig',
            array(
                'form'          => $form->createView(),
                'invoice'       => $invoice,
                'bank_account'  => $this->container->getParameter('bank_account'),
                'own_company'   => $this->container->getParameter('company'),
                'own_contact'   => $this->container->getParameter('contact'),
                'currency'      => $this->container->getParameter('currency'),
            )
        );
    }

    /**
     * Handle the edit invoice action.
     *
     * @param Request $request
     * @param integer $id_company Identifier of company.
     * @param integer $id Identifier of invoice.
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id_company, $id)
    {
        $em = $this->getDoctrine()->getManager();

        // create an invoice and give it some dummy data for this example
        $invoice = $em->getRepository('CrmAppBundle:Invoice')->findOneById($id);

        $originalInvoiceDetails = new ArrayCollection();

        // Create an ArrayCollection of the current InvoiceDetails objects in the database
        foreach ($invoice->getInvoiceDetails() as $invoiceDetail) {
            $originalInvoiceDetails->add($invoiceDetail);
        }

        $form = $this->createForm(new InvoiceType(), $invoice);

        $form->handleRequest($request);
        if ($form->isValid()) {

            // remove the relationship between the invoice detail and the Invoice
            foreach ($originalInvoiceDetails as $invoiceDetail) {
                if (false === $invoice->getInvoiceDetails()->contains($invoiceDetail)) {
                    $em->remove($invoiceDetail);
                }
            }

            // perform some action, such as saving the invoice to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($invoice);
            $em->flush();

            return $this->redirectToRoute('crm_app_company_show', array('id' => $id_company));
        }

        return $this->render(
            'CrmAppBundle:Invoices:edit.html.twig',
            array(
                'form'          => $form->createView(),
                'invoice'       => $invoice,
                'bank_account'  => $this->container->getParameter('bank_account'),
                'own_company'   => $this->container->getParameter('company'),
                'own_contact'   => $this->container->getParameter('contact'),
                'currency'      => $this->container->getParameter('currency'),
            )
        );
    }

    /**
     * Calculate the total amounts for an invoice.
     *
     * @param Invoice $invoice The invoice object.
     * @return array
     */
    private function calculateInvoiceTotalAmounts($invoice)
    {
        $taxable	= 0.00;
        $outlays	= 0.00;
        foreach ($invoice->getInvoiceDetails() as $detail ) {
            if ('outlay' === $detail->getType()) {
                $outlays += $detail->getAmount();
            } else {
                $taxable += $detail->getAmount();
            }
        }

        $vat		= ( $taxable * ( $invoice->getVat() / 100 ) );
        $taxes		= ( -1 * ($taxable * ( $invoice->getTax() / 100 ) ) );
        $total		= ( $taxable + $vat + $taxes + $outlays );

        return array(
            'taxable'	=> round( $taxable, 2 ),
            'vat'		=> round( $vat, 2 ),
            'taxes'		=> round( $taxes, 2 ),
            'outlays'	=> round( $outlays, 2 ),
            'total'		=> round( $total, 2 )
        );
    }

    /**
     * Method to delete an invoice.
     *
     * @param integer $id Identifier of company.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $invoice    = $em->getRepository('CrmAppBundle:Invoice')->findOneById($id);
        $company    = $invoice->getCompany();

        $em->remove($invoice);
        $em->flush();

        $this->addFlash(
            'notice',
            'The invoice "'.$invoice->getReference().'" for company "'.$company->getName().'" has been deleted!'
        );

        return $this->redirectToRoute('crm_app_company_show', array('id' => $company->getId()));
    }

    /**
     * Generates the invoice in PDF format.
     *
     * @param integer $id_company
     * @param integer $id
     */
    public function downloadAction($id_company, $id)
    {
        $em         = $this->getDoctrine()->getManager();
        $invoice    = $em->getRepository('CrmAppBundle:Invoice')->findOneById($id);

        $filename   = $invoice->getReference().'.pdf';

        $html = $this->renderView(
            'CrmAppBundle:Invoices:download.html.twig',
            array(
                'invoice'	        => $invoice,
                'invoice_totals'    => $this->calculateInvoiceTotalAmounts($invoice),
                'bank_account'      => $this->container->getParameter('bank_account'),
                'own_company'       => $this->container->getParameter('company'),
                'own_contact'       => $this->container->getParameter('contact'),
                'currency'          => $this->container->getParameter('currency'),
            )
        );
/*
return $this->render(
    'CrmAppBundle:Invoices:download.html.twig',
    array(
        'invoice'	        => $invoice,
        'invoice_totals'    => $this->calculateInvoiceTotalAmounts($invoice),
        'bank_account'      => $this->container->getParameter('bank_account'),
        'own_company'       => $this->container->getParameter('company'),
        'own_contact'       => $this->container->getParameter('contact'),
        'currency'          => $this->container->getParameter('currency'),
    )
);
*/
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, array('lowquality' => false,'encoding' => 'utf-8')),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"'
            )
        );
    }
}
