<?php

namespace App\Controller\Admin\Media;

use App\Entity\Media\File;
use App\Entity\Media\Folder;
use App\Form\Admin\Media\UploadFileType;
use App\Repository\Media\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/media', name: 'app_admin_media_')]
class FileController extends AbstractController
{
    public function new(FileRepository $fileRepository, Folder $folder, Request $request)
    {

    }

    public function edit(FileRepository $fileRepository, File $file, Request $request)
    {

    }

    #[Route('/folder/file/upload/{slug}', name: 'file_upload', requirements: ['slug' => '.+?'], defaults: ['slug' => null])]
    public function uploadFile(FileRepository $fileRepository, Request $request, ?Folder $rootFolder): Response
    {
        $file   = new File();
        $form   = $this->createForm(UploadFileType::class, $file);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $rootFolder?->addFile($file);
            $fileRepository->save($file, true);

            $this->addFlash('success','Dossier créé avec succès.');

            return $this->redirectToRoute('app_admin_media_folder_index', ['slug' => $rootFolder?->getSlug()]);
        }

        return $this->render('admin/media/file/add.html.twig', [
            'form' => $form,
        ]);
    }
}
