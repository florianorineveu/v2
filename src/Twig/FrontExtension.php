<?php

namespace App\Twig;

use App\Repository\SocialNetworkRepository;
use Doctrine\Common\Collections\Criteria;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FrontExtension extends AbstractExtension
{
    public function __construct(
        private SocialNetworkRepository $socialNetworkRepository
    ) {}

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_social_networks', [$this, 'getSocialNetworks']),
        ];
    }

    public function getSocialNetworks()
    {
        return $this->socialNetworkRepository->findBy([
            'enabled' => true,
        ], [
            'position' => Criteria::ASC,
        ]);
    }
}
