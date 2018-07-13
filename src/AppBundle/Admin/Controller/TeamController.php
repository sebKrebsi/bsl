<?php

namespace AppBundle\Admin\Controller;

use AppBundle\Admin\Form\TeamType;
use AppBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 * @Route("team")
 */
class TeamController extends Controller
{
    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.teams');
        $datatable->buildDatatable();

        return $this->render('admin/team/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="team_results", options={"expose"=true})
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.teams');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new team entity.
     *
     * @Route("/new", name="team_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);

            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            // Here, "getMyFile" returns the "UploadedFile" instance that the form bound in your $myFile property
            $uploadableManager->markEntityToUpload($team, $form->get('image')->getData());

            $em->flush();

            return $this->redirectToRoute('team_show', array('id' => $team->getId()));
        }

        return $this->render('admin/team/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/{id}", name="team_show", options={"expose"=true})
     * @Method("GET")
     * @param Team $team
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('admin/team/show.html.twig', array(
            'team'        => $team,
            'basePath'    => $this->getParameter('base_path_download'),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     * @Route("/{id}/edit", name="team_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Team    $team
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm   = $this->createForm(TeamType::class, $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($editForm->get('image')->getData()) {
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

                // Here, "getMyFile" returns the "UploadedFile" instance that the form bound in your $myFile property
                $uploadableManager->markEntityToUpload($team, $editForm->get('image')->getData());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_edit', array('id' => $team->getId()));
        }

        return $this->render('admin/team/edit.html.twig', array(
            'team'        => $team,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'base_path'   => $this->getParameter('base_path_download')
        ));
    }

    /**
     * Deletes a team entity.
     *
     * @Route("/{id}", name="team_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Team    $team
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Team $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
