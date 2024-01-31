<?php

namespace App\infrastructure\routes\MainRouter {

    use Bramus\Router\Router;

    use function App\infrastructure\routes\category\router as routesCategory;
    use function App\infrastructure\routes\domain\router as routesDomain;
    use function App\infrastructure\routes\section\router as routesSection;
    use function App\infrastructure\routes\qualification\router as routesQualification;
    use function App\infrastructure\routes\questions\router as routesQuestions;
    use function App\infrastructure\routes\dimension\router as routesDimensions;
    use function App\infrastructure\routes\survey\router as routesSurvey;
    use function App\infrastructure\routes\authentication\router as routesAuthentication;

    function categoryRouter(Router $router)
    {
        routesCategory($router);
    }

    function sectionRouter(Router $router)
    {
        routesSection($router);
    }

    function domainRouter(Router $router)
    {
        routesDomain($router);
    }

    function qualificationRouter(Router $router)
    {
        routesQualification($router);
    }

    function questionRouter(Router $router)
    {
        routesQuestions($router);
    }

    function dimensionRouter(Router $router)
    {
        routesDimensions($router);
    }

    function surveyRoutes(Router $router)
    {
        routesSurvey($router);
    }
    function authenticationRoutes(Router $router)
    {
        routesAuthentication($router);
    }
};
