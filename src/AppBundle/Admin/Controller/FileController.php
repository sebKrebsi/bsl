<?php

namespace AppBundle\Admin\Controller;

use AppBundle\Admin\Form\FileType;
use AppBundle\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * File controller.
 *
 * @Route("file")
 */
class FileController extends Controller
{
    /**
     * Lists all file entities.
     *
     * @Route("/", name="file_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.files');
        $datatable->buildDatatable();

        return $this->render('admin/news/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="file_results", options={"expose"=true})
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.files');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new file entity.
     *
     * @Route("/new", name="file_new", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);

            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            // Here, "getMyFile" returns the "UploadedFile" instance that the form bound in your $myFile property
            $uploadableManager->markEntityToUpload($file, $form->get('myFile')->getData());

            $em->flush();

            return $this->redirectToRoute('file_index');
        }

        return $this->render(':admin/file:new.html.twig', array(
            'file' => $file,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing file entity.
     *
     * @Route("/edit/{id}", name="file_edit", options={"expose"=true})
     * @param Request $request
     * @param File    $file
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, File $file)
    {
        $deleteForm = $this->createDeleteForm($file);
        $editForm   = $this->createForm(FileType::class, $file);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');

            // Here, "getMyFile" returns the "UploadedFile" instance that the form bound in your $myFile property
            $uploadableManager->markEntityToUpload($file, $editForm->get('myFile')->getData());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_edit', array('id' => $file->getId()));
        }

        return $this->render(':admin/file:edit.html.twig', array(
            'file'        => $file,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a file entity.
     *
     * @Route("/{id}", name="file_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param File    $file
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, File $file)
    {
        $form = $this->createDeleteForm($file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }

        return $this->redirectToRoute('file_index');
    }

    /**
     * Creates a form to delete a file entity.
     *
     * @param File $file The file entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(File $file)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('file_delete', array('id' => $file->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
