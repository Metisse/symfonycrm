<?php

namespace Crm\AppBundle\Controller;

use Crm\AppBundle\Entity\Company;
use Crm\AppBundle\Form\Type\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompaniesController extends Controller
{
    /**
     * @var integer Page size.
     */
    const PAGE_SIZE = 10;

	/**
	 * Action to show the list of companies.
	 *
     * @param integer $page The current page.
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction($page)
    {
		$companies = $this->getDoctrine()
            ->getRepository('CrmAppBundle:Company')
            ->getCompaniesList($page, self::PAGE_SIZE);

        return $this->render(
			'CrmAppBundle:Companies:list.html.twig',
			array(
                'companies'     => $companies->getIterator(),
                'current_page'  => $page,
                'total_pages'   => ceil( $companies->count() / self::PAGE_SIZE)
            )
		);
	}

	/**
	 * Action to show a company information.
	 *
	 * @param integer $id Company identifier.
     *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$company = $em->getRepository('CrmAppBundle:Company')->findOneById($id);
		return $this->render(
			'CrmAppBundle:Companies:show.html.twig',
			array(
				'company'	=> $company,
				'invoices'	=> $em->getRepository('CrmAppBundle:Invoice')->findByCompany($company),
				'contacts'	=> $em->getRepository('CrmAppBundle:Contact')->findByCompany($company),
			)
		);
	}

    /**
     * Method to show the add form or perform the add company action.
     *
     * @param Request $request The request object.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
	{
		// create a task and give it some dummy data for this example
		$company = new Company();

        return $this->manageCompanyForm($request, $company);
	}

    /**
     * Method to show the edit form or perform the add company action.
     *
     * @param Request $request The request object.
     * @param integer $id Identifier of company.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em         = $this->getDoctrine()->getManager();
        $company    = $em->getRepository('CrmAppBundle:Company')->findOneById($id);

        return $this->manageCompanyForm($request, $company);
    }

    /**
     * Manage the company form for add or edit.
     *
     * @param Request $request The request object.
     * @param Company $company The company object.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    private function manageCompanyForm(Request $request, Company $company)
    {
        $form = $this->createForm(new CompanyType(), $company);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            $this->addFlash(
                'notice',
                'The company "'.$company->getName().'" has been saved!'
            );

            return $this->redirectToRoute('crm_app_company_list');
        }

        return $this->render(
            'CrmAppBundle:Companies:edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Method to delete a company.
     *
     * @param integer $id Identifier of company.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $company    = $em->getRepository('CrmAppBundle:Company')->findOneById($id);

        $em->remove($company);
        $em->flush();

        $this->addFlash(
            'notice',
            'The company "'.$company->getName().'" (#'.$id.') has been deleted!'
        );

        return $this->redirectToRoute('crm_app_company_list');
    }
}
