<?php

namespace App\Service\Media;

use App\Entity\Media\Folder;

class MediaHelper
{
    public function getFolderTree(?Folder $folder, array $children = [])
    {
        if ($folder) {
            array_unshift($children, $folder);
        }

        if ($folder?->getParent()) {
            return $this->getFolderTree($folder->getParent(), $children);
        }

        return $children;
    }
}
