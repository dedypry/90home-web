<div class="container-fluid position-relative nav-bar p-0">
    <div class="container position-relative" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg bg-secondary navbar-dark py-3 py-lg-0 pl-3 pl-lg-5">
            <a href="" class="navbar-brand">
                <h1 class="m-0 display-5 text-white"><span class="text-primary">90</span>HOME</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                <div class="navbar-nav ml-auto py-0">
                    <a href="{{route('home')}}" wire:navigate class="nav-item nav-link {{request()->routeIs('home') ? 'active': ''}}">Home</a>
                    <a href="{{route('about')}}" wire:navigate class="nav-item nav-link {{request()->routeIs('about') ? 'active': ''}}">About</a>
                    <a href="{{route('service')}}" wire:navigate class="nav-item nav-link {{request()->routeIs('service') ? 'active': ''}}">Service</a>
                    <a href="{{route('project')}}" wire:navigate class="nav-item nav-link {{request()->routeIs('project') ? 'active': ''}}">Project</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="#" class="dropdown-item">Blog Grid</a>
                            <a href="#" class="dropdown-item">Blog Detail</a>
                        </div>
                    </div>
                    <a href="{{route('contact')}}" wire:navigate class="nav-item nav-link {{request()->routeIs('contact') ? 'active': ''}}">Contact</a>
                </div>
            </div>
        </nav>
    </div>
</div>
