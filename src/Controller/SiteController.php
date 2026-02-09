<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\View\View;


    final class SiteController
    {
        private View $view;

        public function __construct(View $view)
        {
            $this->view = $view;
        }

        public function home(): void
        {
            $this->view->renderPage('home', [
                'title' => $_SESSION['user_role']
            ]);
        }
    }