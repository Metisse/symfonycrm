<?php

namespace Crm\AppBundle\Controller;

use Crm\AppBundle\Entity\Contact;
use Crm\AppBundle\Form\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactsController extends Controller
{
    /**
     * @var integer Page size.
     */
    const PAGE_SIZE = 25;

    /**
	 * Action to show the list of contacts.
	 *
     * @param Request $request The request object.
     * @param integer $page The current page.
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction(Request $request, $page)
    {
        $filters = array(
            'name'      => $request->request->get('name'),
            'surname'   => $request->request->get('surname')
        );

        $contacts = $this->getDoctrine()
            ->getRepository('CrmAppBundle:Contact')
            ->getContactsList($filters, $page, self::PAGE_SIZE);

        return $this->render(
			'CrmAppBundle:Contacts:list.html.twig',
			array(
                'contacts'	    => $contacts->getIterator(),
                'filters'       => $filters,
                'current_page'  => $page,
                'total_pages'   => ceil( $contacts->count() / self::PAGE_SIZE)
            )
		);
	}

    /**
     * Handle the new contact action.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
	{
		// create a task and give it some dummy data for this example
		$contact = new Contact();

		$form = $this->createForm(new ContactType(), $contact);

		$form->handleRequest($request);
		if ($form->isValid()) {
			// perform some action, such as saving the task to the database
			$em = $this->getDoctrine()->getManager();
			$em->persist($contact);
			$em->flush();

			return $this->redirectToRoute('crm_app_company_show', array('id' => $contact->getCompany()->getId()));
		}

		return $this->render(
			'CrmAppBundle:Contacts:edit.html.twig',
			array(
			'form' => $form->createView(),
		));
	}
}
