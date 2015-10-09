<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 7/10/15
 * Time: 10:50 PM
 */

namespace AppBundle\Services;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AppManager
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function getARoutes()
    {
        $availableApiRoutes = [];
        foreach ($this->router->getRouteCollection()->all() as $name => $route) {
            if (isset($route->getDefaults()['_controller'])) {
                $action = explode('::', $route->getDefaults()['_controller']);
                $route = $route->compile();
                if (strpos($name, "api_") !== 0 && strpos($name, "_") !== 0) {

                    if (isset($action[1]) && $action[1] == 'indexAction') {
                        $emptyVars = [];
                        foreach ($route->getVariables() as $v) {
                            $emptyVars[$v] = $v;
                        }
                        $url = $this->router->generate($name, $emptyVars, UrlGeneratorInterface::ABSOLUTE_PATH);
                        $availableApiRoutes[$name] = $name;
//                        $availableApiRoutes[] = ["name" => $name];
//                        $availableApiRoutes[] = ["name" => $name, "url" => $url, "variables" => $route->getVariables()];
                    }
                }
            }
        }

        return $availableApiRoutes;
    }
}