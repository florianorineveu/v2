<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class IoExtensionRuntime implements RuntimeExtensionInterface
{
    private Request $currentRequest;
    private ?InputBag $cookies = null;

    public function __construct(RequestStack $requestStack) {
        $this->currentRequest = $requestStack->getCurrentRequest();
    }

    public function isMenuCollapsed(): bool
    {
        if (!$this->cookies) {
            $this->cookies = $this->currentRequest->cookies;
        }

        return $this->cookies->has('io/menu/collapsed') && 'true' === $this->cookies->get('io/menu/collapsed');
    }
}
