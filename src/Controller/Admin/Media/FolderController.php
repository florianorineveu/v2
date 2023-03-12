<?php

namespace App\Controller\Admin\Media;

use App\Entity\Media\Folder;
use App\Form\Admin\Media\FolderType;
use App\Repository\Media\FileRepository;
use App\Repository\Media\FolderRepository;
use App\Service\Media\MediaHelper;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/media', name: 'app_admin_media_folder_')]
class FolderController extends AbstractController
{
    #[Route('/{slug}', name: 'index', requirements: ['slug' => '.+'], priority: -9999)]
    public function index(
        FolderRepository $folderRepository,
        FileRepository $fileRepository,
        MediaHelper $mediaHelper,
        $slug = null
    ): Response {
        $rootFolder = $folderRepository->findOneBy(['slug' => $slug]) ?? null;
        $files      = $rootFolder ? $rootFolder->getFiles() : $fileRepository->findBy(
            ['folder'   => null],
            ['fileName' => Criteria::ASC]
        );

        $folders = $folderRepository->findBy(
            ['parent'   => $rootFolder],
            ['name'     => Criteria::ASC]
        );

        return $this->render('admin/media/folder/index.html.twig', [
            'folders'       => $folders,
            'files'         => $files,
            'root_folder'   => $rootFolder,
            'breadcrumb'    => $mediaHelper->getFolderTree($rootFolder),
        ]);
    }

    #[Route('/folder/new/{slug}', name: 'new', requirements: ['slug' => '.+?'], defaults: ['slug' => null])]
    public function new(FolderRepository $folderRepository, Request $request, ?Folder $rootFolder): Response
    {
        $folder = new Folder;
        $form   = $this->createForm(FolderType::class, $folder);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $rootFolder?->addChildFolder($folder);
            $folderRepository->save($folder, true);

            $this->addFlash('success', 'Dossier créé avec succès.');

            return $this->redirectToRoute(
                'app_admin_media_folder_index',
                ['slug' => $rootFolder?->getSlug()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('admin/media/folder/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/folder/edit/{id}', name: 'edit')]
    public function edit(FolderRepository $folderRepository, Folder $folder, Request $request): Response
    {
        $form = $this->createForm(FolderType::class, $folder);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $folderRepository->save($folder, true);

            $this->addFlash('success', 'Dossier modifié avec succès.');

            return $this->redirectToRoute('app_admin_media_folder_index', ['slug' => $folder->getSlug()]);
        }

        return $this->render('admin/media/folder/edit.html.twig', [
            'folder' => $folder,
            'form'   => $form,
        ]);
    }

    #[Route('/folder/remove/{id}', name: 'delete', methods: ['POST'])]
    public function delete(FolderRepository $folderRepository, Folder $folder, Request $request): Response
    {
        $parentFolder = $folder->getParent();

        if ($this->isCsrfTokenValid('delete' . $folder->getId(), $request->request->get('_token'))) {
            $folderRepository->remove($folder, true);

            $this->addFlash('success', 'Dossier supprimé avec succès.');
        }

        return $this->redirectToRoute(
            'app_admin_media_folder_index',
            ['slug' => $parentFolder?->getSlug()],
            Response::HTTP_SEE_OTHER
        );
    }
}
