<?php
declare(strict_types=1);
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var ItemInterface
     */
    private $mainMenu;
    /**
     * @var ItemInterface
     */
    private $mainMenuCurrentItem;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->factory = $factory;
    }

    public function mainMenu(array $options)
    {
        if (!isset($this->mainMenu)) {
            /*
             * To add dropdown functionality add 'dropdown' => true in the 'extras' array
             */
            $this->mainMenu = $this->factory->createItem('root');
            $this->mainMenu->addChild('Dashboard', ['route' => 'homepage', 'extras' => ['icon_class' => 'fa fa-fw fa-dashboard']]);

            $tests = $this->mainMenu->addChild('Tests', ['extras' => ['dropdown' => true, 'icon_class' => 'fa fa-fw fa-flask']]);

            $this->mainMenuCurrentItem = $this->getCurrentMenuItem($this->mainMenu);
            if ($this->mainMenuCurrentItem) {
                $this->mainMenuCurrentItem->setCurrent(true);
            }
        }

        return $this->mainMenu;
    }

    /**
     * @param array $options
     *
     * @return ItemInterface|null|\Knp\Menu\MenuItem
     */
    public function breadcrumbMenu(array $options)
    {
        if (!isset($this->mainMenu)) {
            $this->mainMenu($options);
        }

        return $this->mainMenuCurrentItem ?: $this->factory->createItem('empty')->setDisplay(false);
    }

    /**
     * @param ItemInterface $menu
     *
     * @return ItemInterface|null
     */
    private function getCurrentMenuItem(ItemInterface $menu)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        $uri = rtrim($request->getPathInfo(), '/');

        $uriMap = $this->buildUriMap($menu);

        do {
            if (isset($uriMap[$uri])) {
                return $uriMap[$uri];
            }
        } while (strlen($uri) > 1 && $uri = $this->removeLastUriPart($uri));

        return null;
    }

    private function buildUriMap(ItemInterface $menu): array
    {
        $uriMap = [];

        /** @var ItemInterface $item */
        foreach ($menu as $item) {
            $uri = $item->getUri();
            if (!empty($uri)) {
                $uriMap[rtrim($uri, '/')] = $item;
            }

            $uriMap += $this->buildUriMap($item);
        }

        return $uriMap;
    }

    private function removeLastUriPart(string $uri): string
    {
        $parts = explode('/', $uri);
        array_pop($parts);
        return implode('/', $parts);
    }
}