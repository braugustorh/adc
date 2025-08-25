<!DOCTYPE html>
<html lang="es">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ADC Plataforma | SEDYCO</title>

    <meta name="keywords" content="ADC - SEDYCO" />
    <meta name="description" content="Plataforma para la Evaluación al Desempeño y el Clima Organizacional">
    <meta name="author" content="NetInnfode">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Web Fonts  -->
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/theme-elements.css">
    <link rel="stylesheet" href="css/theme-blog.css">
    <link rel="stylesheet" href="css/theme-shop.css">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="css/demos/demo-business-consulting-3.css">

    <!-- Skin CSS -->
    <link id="skinCSS" rel="stylesheet" href="css/skins/skin-business-consulting-3.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

</head>

<body data-plugin-cursor-effect>
<div class="body">

    <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 85}">
        @if(session('success'))
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div class="toast-container top-0 end-0 p-4">

                    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-check-circle"></i><span> <strong>  Gracias!...</strong> hemos recibido tu mensaje.</span>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="header-body border-top-0">
            <div class="header-top header-top-default header-top-borders border-bottom-0 bg-color-light">
                <div class="container">
                    <div class="header-row">
                        <div class="header-column justify-content-between">
                            <div class="header-row">
                                <nav class="header-nav-top w-100 w-md-50pct w-xl-100pct">
                                    <ul class="nav nav-pills d-inline-flex custom-header-top-nav-background pe-5">
                                        <li class="nav-item py-2 d-inline-flex z-index-1">
												<!--	<span class="d-flex align-items-center p-0">
														<span>
															<img width="25" src="img/demos/adc/icons/phone.svg" alt="Phone Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
														</span>
														<a class="text-color-light text-decoration-none font-weight-semibold text-3-5 ms-2" href="tel:1234567890" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">(800) 123-4567</a>
													</span> -->
                                            <span class="font-weight-normal align-items-center px-0 d-none d-xl-flex ms-3">
														<span>
															<img width="25" src="img/demos/adc/icons/email.svg" alt="Email Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
														</span>
														<a class="text-color-light text-decoration-none font-weight-semibold text-3-5 ms-2" href="mailto:contactorh@adcentrales.com" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">contactorh@adcentrales.com</a>
													</span>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="d-flex align-items-center w-100">
                                    <ul class="ps-0 ms-auto mb-0">
                                        <li class="nav-item font-weight-semibold text-1 text-lg-2 text-color-dark d-none d-md-flex justify-content-end me-3">
                                            <!--	Mon - Sat 9:00am - 6:00pm / Sunday - CLOSED -->
                                        </li>
                                    </ul>
                                    <ul class="social-icons social-icons-clean social-icons-icon-dark social-icons-big m-0 ms-lg-2">
                                        <li class="social-icons-instagram">
                                            <a href="http://www.instagram.com/" target="_blank" class="text-4" title="Instagram" data-cursor-effect-hover="fit"><i class="fab fa-instagram"></i></a>
                                        </li>
                                        <li class="social-icons-twitter">
                                            <a href="http://www.twitter.com/" target="_blank" class="text-4" title="Twitter" data-cursor-effect-hover="fit"><i class="fab fa-x-twitter"></i></a>
                                        </li>
                                        <li class="social-icons-facebook">
                                            <a href="http://www.facebook.com/" target="_blank" class="text-4" title="Facebook" data-cursor-effect-hover="fit"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container" style="height: 117px;">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="{{route('welcome')}}">
                                    <img alt="Porto" width="192" height="82" src="img/logo_header_home.png">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end w-100">
                        <div class="header-row">
                            <div class="header-nav header-nav-links order-2 order-lg-1">
                                <div class="header-nav-main header-nav-main-square header-nav-main-text-capitalize header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                    <nav class="collapse">
                                        <ul class="nav nav-pills" id="mainNav">
                                            <li>
                                                <a class="nav-link active" href="{{route('welcome')}}">
                                                    Inicio
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="{{ route('about') }}">
                                                    Acerca de Nosotros
                                                </a>
                                            </li>
                                            <li class="dropdown">
                                                <a class="nav-link dropdown-toggle" href="{{route('modules')}}">
                                                    Módulos
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{route('modules-360-detail')}}" class="dropdown-item">
                                                            Evaluación 360
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-f2f')}}" class="dropdown-item">
                                                            Face to Face
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-9box')}}" class="dropdown-item">
                                                            9 Box
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-clima')}}" class="dropdown-item">
                                                            Clima Organizacional
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-tablero-de-control')}}" class="dropdown-item">
                                                            Tablero de control
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-portafolio')}}" class="dropdown-item">
                                                            Portafolio
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-nom035')}}" class="dropdown-item">
                                                            NOM 035
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('modules-psicometria')}}" class="dropdown-item">
                                                            Psicometrías
                                                        </a>
                                                    </li>

                                                </ul>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="{{route('questions')}}">
                                                    Preguntas Frecuentes
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="{{ route('contact') }}">
                                                    Directorio
                                                </a>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-column header-column-search justify-content-end align-items-center d-flex w-auto flex-row">
                        <a href="/dashboard" class="btn btn-dark custom-btn-style-1 font-weight-semibold text-3-5 btn-px-3 py-2 ws-nowrap ms-4 d-none d-lg-block" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light"><span>Ingresar</span></a>
                        <div class="header-nav-features header-nav-features-no-border">
                            <div class="header-nav-feature header-nav-features-search d-inline-flex">
                                <a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search">
                                    <i class="icons icon-magnifier header-nav-top-icon text-3-5 text-color-dark text-color-hover-primary font-weight-semibold top-3"></i>
                                </a>
                                <div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed border-radius-0" id="headerTopSearchDropdown">
                                    <form role="search" action="#" method="get">
                                        <div class="simple-search input-group">
                                            <input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Buscar...">
                                            <button class="btn" type="submit" aria-label="Search">
                                                <i class="icons icon-magnifier header-nav-top-icon text-color-dark text-color-hover-primary top-2"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div role="main" class="main">

        <section class="section section-height-3 section-with-shape-divider position-relative border-0 m-0" data-plugin-parallax data-plugin-options="{'speed': 1.5, 'parallaxHeight': '120%'}" data-image-src="img/demos/adc/backgrounds/background-1.jpg">
            <img src="img/demos/adc/pantalla_dashboard-L.png" class="img-fluid position-absolute top-0 right-0 d-none d-md-block appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100" alt="" />
            <div class="container pb-5 pb-xl-0 mt-md-3 mb-5">
                <div class="row">
                    <div class="col-md-7 col-lg-12">
                        <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="0">
                            <h1 class="custom-text-background custom-big-font-size-1 text-14 font-weight-bold float-xl-center clearfix line-height-1 custom-ws-mobile-wrap ws-nowrap pb-2 mb-3 mb-xl-5"
                                style="background-image: url('img/demos/adc/text-background.jpg');">SEDyCO
                                <br></h1>
                        </div>
                    </div>
                </div>
                <div class="row pb-5 mb-5">
                    <div class="col-md-7 col-xl-5 pb-5 pb-xl-0 mb-5">
                        <strong class="d-block font-weight-semibold text-color-dark text-5-5 line-height-4 mb-3 pb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Sistema de Evaluación al Desempeño y  <span class="custom-highlight-text-1 font-weight-bold">Clima Organizacional</span></strong>
                        <p class="text-3-5 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">El SEDyCO de ADC comunica oportunidades de mejora con los colaboradores e impulsa su desempeño en la empresa.</p>
                        <a href="#aboutus" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="d-inline-flex align-items-center text-decoration-none appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
                            <img width="30" height="30" src="img/demos/business-consulting-3/icons/mouse.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary me-2'}" />
                            Desplazar
                        </a>
                    </div>
                </div>
            </div>
            <div class="shape-divider shape-divider-bottom" style="height: 212px;">
                <div class="shape-divider-horizontal-animation shape-divider-horizontal-animation-to-left">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 212" preserveAspectRatio="xMinYMin">
                        <polygon fill="#F3F3F3" points="0,75 479,161 1357,28 1701,56 1920,26 1920,213 0,212 "/>
                        <polygon fill="#FFFFFF" points="0,91 481,177 1358,44 1702,72 1920,42 1920,212 0,212 "/>
                    </svg>
                </div>
            </div>
        </section>

        <div class="container" style="margin-top: -310px;">
            <div class="row">
                <div class="col-xl-7 ms-xl-auto">
                    <div class="owl-carousel owl-theme custom-carousel-box-shadow-1 custom-dots-style-1 mb-0" data-plugin-options="{'responsive': {'576': {'items': 1}, '768': {'items': 2}, '992': {'items': 2}, '1200': {'items': 2}}, 'margin': 20, 'loop': false, 'nav': false, 'autoplay': true, 'autoplayTimeout': 5000, 'dots': true}" style="height: 398px;">
                        <div>
                            <a href="#" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                                <div class="card border-0">
                                    <div class="card-body text-center py-5">
                                        <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="75" viewBox="0 -960 960 960" width="75"  style="enable-background:new 0 0 74 74;" ><path d="M263.914-840q59.841 0 116.442 24.217 56.601 24.218 99.644 67.174 43.043-42.956 99.644-67.174Q636.245-840 696-840q109.761 0 186.88 77.12Q960-685.761 960-575.882q0 37.678-10.852 77.713-10.853 40.034-33.822 79.995-13.956-14.478-31.772-23-17.815-8.522-37.25-13.565 18.007-31.467 27.199-61.825 9.193-30.358 9.193-59.436 0-77.524-54.586-132.11-54.586-54.586-132.11-54.586-40.391 0-98.739 25-58.348 25-117.261 96.109-58.913-71.109-116.761-96.109t-99.239-25q-77.524 0-131.99 54.586Q77.544-653.524 77.544-576q0 29.433 9.11 60.129 9.11 30.697 27.281 61.893-19.435 4.043-37.25 13.804t-31.011 23q-24.07-39.956-34.872-80.118Q0-537.454 0-575.882 0-685.761 77.12-762.88 154.239-840 263.914-840ZM30.674-53.152q-16.946 0-28.049-11.09Q-8.478-75.334-8.478-91.368v-23.675q0-42.629 43.25-68.848T150-210.109q7.805 0 15.768.75 7.963.75 14.275.011-9 19-14.119 39.674-5.12 20.674-5.12 44.044v72.478H30.674Zm240 0q-16.946 0-28.049-11.09-11.103-11.091-11.103-27.144v-33.656q0-69.223 68.368-112.145 68.367-42.922 180.083-42.922 111.675 0 180.09 42.902 68.415 42.901 68.415 112.092v33.81q0 15.972-11.09 27.062-11.091 11.091-27.062 11.091H270.674Zm528.522 0v-72.762q0-22.178-4.62-43.306-4.619-21.128-13.619-40.4 5.312.511 13.275.011t15.85-.5q71.396 0 114.896 26.09t43.5 69.41v23.242q0 16.034-11.09 27.124-11.091 11.091-27.062 11.091h-131.13Zm-319.212-153q-71.027 0-115.669 21.141-44.641 21.142-50.641 53.902v4h332.652v-5q-5-31.76-50.158-52.902-45.158-21.141-116.184-21.141Zm-330.087-31.957q-31.897 0-53.517-21.718-21.62-21.718-21.62-53.729 0-30.792 21.793-52.911 21.793-22.12 53.62-22.12 31.827 0 53.566 22.208t21.739 53.62q0 31.411-21.842 53.031-21.842 21.619-53.739 21.619Zm660 0q-31.897 0-53.517-21.718-21.619-21.718-21.619-53.729 0-30.792 21.792-52.911 21.793-22.12 53.62-22.12 31.827 0 53.566 22.208t21.739 53.62q0 31.411-21.842 53.031-21.842 21.619-53.739 21.619Zm-330.132-71q-52.765 0-90.504-37.974-37.739-37.974-37.739-90.739 0-52.765 37.974-90.504 37.975-37.739 90.739-37.739 52.765 0 90.504 37.974 37.739 37.975 37.739 90.739 0 52.765-37.974 90.504-37.975 37.739-90.739 37.739Zm.151-183.239q-23.177 0-38.807 15.79-15.631 15.789-15.631 39.13t15.786 38.852q15.785 15.511 38.891 15.511 23.106 0 38.856-15.693t15.75-38.891q0-23.199-15.834-38.949-15.833-15.75-39.011-15.75ZM480-127.109Zm0-310.478Z"></path></svg>

                                        </div>

                                        <div class="custom-crooked-line">
                                            <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                                <svg version="1.1" id="icon_161722912979002" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1196.9 92" style="enable-background:new 0 0 1196.9 92;" xml:space="preserve" data-filename="infinite-crooked-line.svg" width="154" height="26">
															<g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                                <path d="M1620.4,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326L0,169.6l87.8-82.2l85-85L505.4,335l245,245
																	l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290l290-290l290,290l290,290
																	l290-290l290-290l291,291l291,291l247-243L5983.3,0.1l85,84l84.4,85.6L5723.4,592l-333,327l-290-289l-290-290l-290,290l-290,290
																	l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L1620.4,630z"></path>
                                                            </g>
                                                    <g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                        <path d="M7432.8,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326l-405.4-406.4l84.4-84.3l86.5-85.2
																	L6317.8,335l245,245l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290
																	l290-290l290,290l290,290l290-290l290-290l291,291l291,291l247-243l343.9-338.9l85,84l88.6,81.4L11535.8,592l-333,327l-290-289
																	l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L7432.8,630z"></path>
                                                    </g>
															</svg>
                                            </div>
                                        </div>
                                        <h2 class="text-5 font-weight-semibold mb-1">Ganar-Ganar</h2>
                                        <p class="pb-1 mb-2">Desarrolla tus talentos en un entorno que te motive y explota al máximo tus habilidades.</p>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="modules.blade.php" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                                <div class="card border-0">
                                    <div class="card-body text-center py-5">
                                        <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="75" viewBox="0 -960 960 960" width="75">
                                                <path d="M627.226-528.761q24.404 0 41.774-17.226 17.37-17.227 17.37-41.631t-17.276-41.773q-17.276-17.37-41.75-17.37t-41.605 17.191q-17.13 17.192-17.13 41.75 0 24.559 17.096 41.809 17.097 17.25 41.521 17.25Zm-294.57 0q24.474 0 41.605-17.142 17.13-17.142 17.13-41.63 0-24.489-17.096-41.858-17.097-17.37-41.521-17.37-24.404 0-41.774 17.276-17.37 17.275-17.37 41.75 0 24.474 17.276 41.724 17.276 17.25 41.75 17.25ZM480.013-62.804q-85.856 0-162.313-32.713-76.457-32.712-133.174-89.133-56.718-56.42-89.22-132.95-32.502-76.531-32.502-162.387T95.517-642.3q32.712-76.457 89.095-133.187 56.383-56.73 132.931-89.339t162.424-32.609q85.876 0 162.361 32.801 76.485 32.801 133.197 89.202 56.713 56.402 89.311 132.974 32.599 76.573 32.599 162.478 0 85.889-32.82 162.342-32.819 76.453-89.252 133.141-56.433 56.689-132.963 89.19-76.531 32.503-162.387 32.503ZM480-480Zm.181 339.891q141.998 0 240.854-99.036 98.856-99.037 98.856-241.036 0-141.998-99.036-240.854-99.037-98.856-241.036-98.856-141.998 0-240.854 99.036-98.856 99.037-98.856 241.036 0 141.998 99.036 240.854 99.037 98.856 241.036 98.856Zm-.677-113.761q60.051 0 111.262-27.995 51.21-27.996 81.56-77.165 6-12.361-1.32-23.861t-21.953-11.5H311.131q-15.355 0-22.406 11.213-7.051 11.214.188 23.908 29.283 49.419 80.544 77.41 51.26 27.99 110.047 27.99Z"></path></svg>
                                        </div>
                                        <div class="custom-crooked-line">
                                            <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                                <svg version="1.1" id="icon_161722912979002" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1196.9 92" style="enable-background:new 0 0 1196.9 92;" xml:space="preserve" data-filename="infinite-crooked-line.svg" width="154" height="26">
															<g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                                <path d="M1620.4,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326L0,169.6l87.8-82.2l85-85L505.4,335l245,245
																	l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290l290-290l290,290l290,290
																	l290-290l290-290l291,291l291,291l247-243L5983.3,0.1l85,84l84.4,85.6L5723.4,592l-333,327l-290-289l-290-290l-290,290l-290,290
																	l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L1620.4,630z"></path>
                                                            </g>
                                                    <g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                        <path d="M7432.8,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326l-405.4-406.4l84.4-84.3l86.5-85.2
																	L6317.8,335l245,245l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290
																	l290-290l290,290l290,290l290-290l290-290l291,291l291,291l247-243l343.9-338.9l85,84l88.6,81.4L11535.8,592l-333,327l-290-289
																	l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L7432.8,630z"></path>
                                                    </g>
															</svg>
                                            </div>
                                        </div>
                                        <h2 class="text-5 font-weight-semibold mb-1">Futuro más sólido</h2>
                                        <p class="pb-1 mb-2">Siéntete motivado, preparado y comprometido con tu trabajo, haciendo lo que más te gusta. </p>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="#" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                                <div class="card border-0">
                                    <div class="card-body text-center py-5">
                                        <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                            <svg aria-hidden="true" width="75" height="75" class="e-font-icon-svg e-fas-hourglass-half" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><path d="M360 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24 0 90.965 51.016 167.734 120.842 192C75.016 280.266 24 357.035 24 448c-13.255 0-24 10.745-24 24v16c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24v-16c0-13.255-10.745-24-24-24 0-90.965-51.016-167.734-120.842-192C308.984 231.734 360 154.965 360 64c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24zm-75.078 384H99.08c17.059-46.797 52.096-80 92.92-80 40.821 0 75.862 33.196 92.922 80zm.019-256H99.078C91.988 108.548 88 86.748 88 64h208c0 22.805-3.987 44.587-11.059 64z"></path></svg>
                                        </div>
                                        <div class="custom-crooked-line">
                                            <div class="animated-icon animated fadeIn svg-fill-color-primary">
                                                <svg version="1.1" id="icon_161722912979002" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1196.9 92" style="enable-background:new 0 0 1196.9 92;" xml:space="preserve" data-filename="infinite-crooked-line.svg" width="154" height="26">
															<g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                                <path d="M1620.4,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326L0,169.6l87.8-82.2l85-85L505.4,335l245,245
																	l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290l290-290l290,290l290,290
																	l290-290l290-290l291,291l291,291l247-243L5983.3,0.1l85,84l84.4,85.6L5723.4,592l-333,327l-290-289l-290-290l-290,290l-290,290
																	l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L1620.4,630z"></path>
                                                            </g>
                                                    <g transform="translate(0.000000,92.000000) scale(0.100000,-0.100000)">
                                                        <path d="M7432.8,630l-290-290l-286,286c-250,249-289,285-305,276c-11-6-161-153-334-326l-405.4-406.4l84.4-84.3l86.5-85.2
																	L6317.8,335l245,245l285-285c157-157,289-285,295-285c5,0,138,128,295,285l285,285l290-290l290-290l290,290l290,290l290-290
																	l290-290l290,290l290,290l290-290l290-290l291,291l291,291l247-243l343.9-338.9l85,84l88.6,81.4L11535.8,592l-333,327l-290-289
																	l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290l-290-290l-290-290l-290,290l-290,290L7432.8,630z"></path>
                                                    </g>
															</svg>
                                            </div>
                                        </div>
                                        <h2 class="text-5 font-weight-semibold mb-1">Ahorra tiempo</h2>
                                        <p class="pb-1 mb-2">Optimiza procesos, elimina el papeleo innecesario y simplifica la gestión de recursos humanos. </p>

                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div id="aboutus" class="row align-items-xl-center pt-4 mt-5">
                <div class="col-md-12 col-lg-7 mb-5 mb-lg-0">
                    <div class="row row-gutter-sm">
                        <div class="col-12">
                            <img src="img/demos/adc/cabecera_2adc.webp" class="img-fluid" alt="" />
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 ps-lg-4 ps-xl-5">
                    <h2 class="custom-highlight-text-1 d-inline-block line-height-5 text-4 positive-ls-3 font-weight-medium text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter">¿Cuál es el Objetivo?</h2>
                    <h3 class="text-9 text-lg-5 text-xl-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Lograr equipos más productivos.  </h3>
                    <p class="text-3-5 pb-1 mb-4 mb-lg-2 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Transformar los equipos de trabajo por equipos altamente competitivos, a través de una <strong>Metodología Focalizada</strong>  y con el <strong>Sistema de Evaluación al Desempeño y Clima Organizacional</strong>.</p>
                    <div class="row align-items-center pb-2 mb-4 mb-lg-1 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
                        <div class="col-5">
                            <div class="d-flex">
                                <img width="63" height="63" src="img/demos/business-consulting-3/icons/label.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'd-lg-none d-xl-block'}" />
                                <span class="text-3 font-weight-bold text-color-dark pt-2 ms-2">
											<strong class="d-block font-weight-bold text-9 mb-2">100%</strong>
											a la medida
										</span>
                            </div>
                        </div>
                        <div class="col-7">
                            <blockquote class="custom-blockquote-style-1 m-0 pt-1 pb-2">
                                <p class="mb-0">Plataforma diseñada para cubrir las necesidades de ADC. </p>
                            </blockquote>
                        </div>
                    </div>
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
                        <a href="/dashboard" class="btn btn-primary custom-btn-style-1 font-weight-semibold btn-px-4 btn-py-2 text-3-5"
                           data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
                            <span>Ingresar</span></a>
                    </div>
                </div>
            </div>
        </div>

        <!--div class="container-fluid pt-5 mt-5 mb-4">
            <div class="row">
                <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">
                    <div class="owl-carousel owl-theme carousel-center-active-item custom-carousel-vertical-center-items custom-dots-style-1" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 3}, '768': {'items': 3}, '992': {'items': 5}, '1200': {'items': 5}, '1600': {'items': 7}}, 'autoplay': false, 'autoplayTimeout': 3000, 'dots': true}">
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-8.png" alt="" style="max-width: 90px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-9.png" alt="" style="max-width: 140px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-10.png" alt="" style="max-width: 140px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-11.png" alt="" style="max-width: 140px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-12.png" alt="" style="max-width: 100px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-13.png" alt="" style="max-width: 100px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-14.png" alt="" style="max-width: 140px;" />
                        </div>
                        <div class="text-center">
                            <img class="d-inline-block img-fluid" src="img/logos/logo-15.png" alt="" style="max-width: 110px;" />
                        </div>
                    </div>
                </div>
            </div>
        </div -->

        <section class="section section-height-4 section-with-shape-divider bg-color-grey border-0 pb-5 m-0">
            <div class="shape-divider" style="height: 123px;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 123" preserveAspectRatio="xMinYMin">
                    <polygon fill="#F4F4F4" points="0,90 221,60 563,88 931,35 1408,93 1920,41 1920,-1 0,-1 "/>
                    <polygon fill="#FFFFFF" points="0,75 219,44 563,72 930,19 1408,77 1920,25 1920,-1 0,-1 "/>
                </svg>
            </div>
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-lg-11 col-xl-10 text-center">
                        <h2 class="custom-highlight-text-1 d-inline-block line-height-5 text-4 positive-ls-3 font-weight-medium text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">PRINCIPALES</h2>
                        <h3 class="text-9 line-height-3 text-transform-none font-weight-semibold mb-3 pb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Módulos</h3>
                        <p class="text-3-5 pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
                            SEDyCO es una plataforma innovadora que combina diversos módulos estratégicos para ayudarte a medir, analizar y potenciar el desempeño de tu equipo de trabajo en todos los niveles. Con herramientas como:
                        </p>
                    </div>
                </div>
                <div class="row row-gutter-sm justify-content-center mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-f2f')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">Face to Face</h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/f2f.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Revisa desempeño y planificar mejoras en reuniones <br> jefe-colaborador.</p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-360-detail')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-2">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">Evaluación 360</h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/module-360.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Realiza evaluaciones para medir desempeño desde múltiples ángulos en diversos roles.. </p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-9box')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">
                                            9 Box
                                        </h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/9box.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Sitúa a los colaboradores en 9 cuadrantes para evaluar potencial y desempeño.</p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-clima')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">
                                            Clima Organizacional
                                        </h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/clima.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Presenta el estado actual de la organización para apoyar diagnósticos y decisiones. </p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-portafolio')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">Portafolio Digital</h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/portafolio.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Visualiza y descarga los documentos de cada uno de los colaboradores. </p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-tablero-de-control')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">Tablero de Control</h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/tablero.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Visualiza el estado actual de indicadores, planes y estrategias de la organización. </p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4 mb-4">
                        <a href="{{route('modules-nom035')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">
                                            NOM 035
                                        </h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/nom035.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">Identifica y previene riesgos psicosociales para cuidar la salud emocional de los empleados.</p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-9 col-md-6 col-lg-4">
                        <a href="{{route('modules-psicometria')}}" class="custom-link-hover-effects text-decoration-none" data-cursor-effect-hover="plus">
                            <div class="card box-shadow-4">
                                <div class="card-img-top position-relative overlay overlay-show">
                                    <div class="position-absolute bottom-0 left-0 w-100 py-3 px-4 z-index-3">
                                        <h4 class="font-weight-semibold text-color-light text-6 mb-1">
                                            Psicometrías
                                        </h4>
                                        <div class="custom-crooked-line">
                                            <img width="154" height="26" src="img/demos/business-consulting-3/icons/infinite-crooked-line.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 154px;" />
                                        </div>
                                    </div>
                                    <img src="img/demos/business-consulting-3/services/psicometria.webp" class="img-fluid" alt="Card Image" />
                                </div>
                                <div class="card-body d-flex align-items-center custom-view-more px-4">
                                    <p class="card-text w-100 mb-0">
                                        Realiza diversas pruebas que ayuden a detectar personalidad, inteligencia y comportamiento. </p>
                                    <img width="50" height="50" class="w-auto" src="img/demos/business-consulting-3/icons/arrow-right.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 50px;" />
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <a href="/dashboard" class="btn btn-primary custom-btn-style-1 font-weight-semibold btn-px-4 btn-py-2 text-3-5" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
                            <span>Ingresar</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-height-4 section-with-shape-divider position-relative bg-dark border-0 m-0">
            <div class="shape-divider shape-divider-reverse-x z-index-3" style="height: 102px;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 102" preserveAspectRatio="xMinYMin">
                    <polygon fill="#F3F3F3" points="0,65 220,35 562,63 931,10 1410,68 1920,16 1920,103 0,103 "/>
                    <polygon fill="#F4F4F4" points="0,82 219,51 562,78 931,26 1409,83 1920,32 1920,103 0,103 "/>
                </svg>
            </div>
            <div class="position-absolute top-0 left-0 h-100 d-none d-lg-block overlay overlay-show overlay-color-primary" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="img/demos/business-consulting-3/parallax/parallax-1.jpg" style="width: 40%;"></div>
            <div class="container position-relative z-index-3 pt-5 mt-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="custom-text-background custom-big-font-size-1 text-15 font-weight-bold float-end clearfix line-height-1 lazyload pe-xl-5 me-3 mb-0 d-none d-lg-block" data-bg-src="img/demos/adc/backgrounds/text-background-2.jpg" data-plugin-float-element data-plugin-options="{'startPos': 'top', 'speed': 0.6, 'transition': true, 'horizontal': true, 'transitionDuration': 1000, 'isInsideSVG': true}">
                            BENEFICIOS
                        </h2>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="custom-highlight-text-1 d-inline-block line-height-5 text-4 positive-ls-3 font-weight-medium text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Por qué usar SEDyCO?</h2>
                        <h3 class="text-9 line-height-3 text-transform-none font-weight-medium text-color-light ls-0 mb-3 pb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Potencia el desempeño de tus colaboradores</h3>
                        <p class="text-3-5 pb-2 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">Con el sistema de gestión de desempeño:</p>
                        <ul class="list ps-0 pe-lg-5 mb-0">
                            <li class="d-flex align-items-start pb-1 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Mejora de la capacitación y desarrollo .</span>
                            </li>
                            <li class="d-flex align-items-start pb-1 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1250">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Retención de talentos
										</span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1500">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Mejor comunicación interna entre los Deptos involucrados</span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1750">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Evaluación de desempeño objetiva</span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="2000">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Reducción de conflictos laborales </span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="2250">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Alineación con los objetivos organizacionales</span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="2500">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Facilitar la reestructuración organizacional</span>
                            </li>
                            <li class="d-flex align-items-start appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="2750">
                                <i class="fas fa-check text-color-light text-4 custom-bg-color-grey-1 rounded-circle p-3"></i>
                                <span class="text-3-5 ps-3">Cumplimiento de normativas laborales</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="row align-items-center py-4 my-5 mb-lg-0 my-xl-5">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <h2 class="text-9 line-height-3 text-transform-none font-weight-semibold mb-4">La medición de habilidades, un diferenciador estratégico para tu empresa.</h2>
                    <p class="text-3-5 pb-3 mb-4">La medición de habilidades es reconocer el valor de cada colaborador. Al identificar fortalezas y áreas de mejora, motivamos a nuestros equipos, aumentamos su compromiso y creamos un ambiente de trabajo más positivo y productivo.</p>
                    <div class="progress-bars pb-4">
                        <div class="progress-label d-flex justify-content-between">
                            <span class="text-color-dark font-weight-semibold text-2">RETENCIÓN DE TALENTO:</span>
                            <span class="text-color-dark font-weight-semibold text-2">90%</span>
                        </div>
                        <div class="progress progress-xs progress-no-border-radius bg-color-grey mb-4">
                            <div class="progress-bar progress-bar-primary" data-appear-progress-animation="90%"></div>
                        </div>

                        <hr class="my-0">

                        <div class="progress-label d-flex justify-content-between pt-2">
                            <span class="text-color-dark font-weight-semibold text-2">INCREMENTO EN LA PRODUCTIVIDAD:</span>
                            <span class="text-color-dark font-weight-semibold text-2">75%</span>
                        </div>
                        <div class="progress progress-xs progress-no-border-radius bg-color-grey mb-4">
                            <div class="progress-bar progress-bar-primary" data-appear-progress-animation="75%"></div>
                        </div>

                        <hr class="my-0">

                        <div class="progress-label d-flex justify-content-between pt-2">
                            <span class="text-color-dark font-weight-semibold text-2">SATISFACCIÓN DEL COLABORADOR</span>
                            <span class="text-color-dark font-weight-semibold text-2">85%</span>
                        </div>
                        <div class="progress progress-xs progress-no-border-radius bg-color-grey mb-4">
                            <div class="progress-bar progress-bar-primary" data-appear-progress-animation="85%"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <img src="img/demos/adc/principal.webp" class="img-fluid" alt="" />
                </div>
            </div>
        </div>



        <section class="section section-with-shape-divider position-relative bg-dark border-0 m-0">
            <div class="shape-divider shape-divider-reverse-x z-index-3" style="height: 102px;">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 102" preserveAspectRatio="xMinYMin">
                    <polygon fill="#F3F3F3" points="0,65 220,35 562,63 931,10 1410,68 1920,16 1920,103 0,103 "/>
                    <polygon fill="#EDEDED" points="0,82 219,51 562,78 931,26 1409,83 1920,32 1920,103 0,103 "/>
                </svg>
            </div>
            <div class="position-absolute top-0 right-0 overlay overlay-show overlay-color-primary overlay-op-9 h-100 lazyload d-none d-md-block" data-bg-src="img/demos/adc/backgrounds/background-2.jpg" style="width: 32%; background-size: cover; background-position: center;"></div>
            <div class="container">
                <div class="row align-items-center pt-5 pb-xl-5 mt-5">
                    <div class="col-md-7 col-lg-8 py-4 my-2 ms-md-3 ms-lg-0">
                        <h2 class="custom-highlight-text-1 d-inline-block line-height-5 text-4 positive-ls-3 font-weight-medium text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">Estamos para escucharte</h2>
                        <h3 class="text-9 line-height-3 text-transform-none font-weight-medium text-color-light ls-0 mb-3 pb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Envíanos tus dudas, comentarios y sugerencias.</h3>
                        <p class="text-3-5 pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">{{--AQUÍ LO DEL FORM   --}}</p>
                        <form
                            class="contact-form form-style-4 form-placeholders-light form-errors-light mb-5 mb-lg-0"
                            action="{{ route('welcome.submit') }}"
                            id="form"
                            method="POST">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{session('success')}}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col">
                                    <input type="text"
                                           value=""
                                           data-msg-required="Escribe tu Nombre."
                                           maxlength="100"
                                           class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                           name="name"
                                           placeholder="* Nombre Completo" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <input type="email" value=""
                                           data-msg-required="Escribe un correo electrónico válido"
                                           data-msg-email="Ingresa un correo válido."
                                           maxlength="100"
                                           class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                           name="email"
                                           placeholder="* Correo Electrónico" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <input type="text" value=""
                                           data-msg-required="Escribe el nombre de la terminal"
                                           data-msg-email="Ingresa una terminal válido"
                                           maxlength="100"
                                           class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                           name="terminal"
                                           placeholder="* Nombre de Termial">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                                    <textarea maxlength="5000"
                                                              data-msg-required="Please enter your message."
                                                              rows="5"
                                                              class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                                              name="message" placeholder="* Mensaje" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                @endif
                                <!-- Mensaje de error -->
                                @error('g-recaptcha-response')
                                <div
                                    class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-group col">
                                    <button type="submit"
                                            class="btn btn-primary custom-btn-style-1 font-weight-semibold btn-px-4 btn-py-2 text-3-5" data-loading-text="Loading..." data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
                                        <span>Enviar Mensaje</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="section section-height-3 border-0 m-0 lazyload" data-bg-src="img/demos/adc/backgrounds/background-3.jpg">
            <div class="container py-4">
                <div class="row">
                    <div class="col text-center">
                        <h2 class="custom-highlight-text-1 d-inline-block line-height-5 text-4 positive-ls-3 font-weight-medium text-color-primary mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">TESTIMONIALES</h2>
                        <h3 class="text-9 line-height-3 text-transform-none font-weight-semibold text-color-dark pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">Qué es lo que los colaboradores dicen</h3>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-11 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
                        <div class="owl-carousel owl-theme custom-nav-style-1 nav-style-1 nav-svg-arrows-1 nav-outside custom-dots-style-2 bg-light box-shadow-4 mb-0" data-plugin-options="{'responsive': {'0': {'items': 1, 'dots': true}, '768': {'items': 1}, '992': {'items': 1, 'nav': true, 'dots': false}, '1200': {'items': 1, 'nav': true, 'dots': false}}, 'loop': false, 'autoHeight': true}">
                            <div class="py-5 px-lg-5">
                                <div class="testimonial testimonial-style-2 px-4 mx-xl-5 my-3">
                                    <img width="40" height="40" src="img/demos/business-consulting-3/icons/left-quote.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 40px;" />
                                    <blockquote>
                                        <p class="text-color-dark text-4 line-height-8 alternative-font-4 mb-0">Cras a elit sit amet leo accumsan volutpat. Suspendisse hendreriast ehicula leo, vel efficitur felis ultrices non. Cras a elit sit amet leo acun volutpat. Suspendisse hendrerit vehicula leo, vel efficitur fel.</p>
                                    </blockquote>
                                    <div class="testimonial-author">
                                        <p>
                                            <strong class="font-weight-bold text-5-5 negative-ls-1">- Juan Dunas</strong>
                                        <p class="text-color-dark mb-0">Colaborador Puesto</p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-5 px-lg-5">
                                <div class="testimonial testimonial-style-2 px-4 mx-xl-5 my-3">
                                    <img width="40" height="40" src="img/demos/business-consulting-3/icons/left-quote.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" style="width: 40px;" />
                                    <blockquote>
                                        <p class="text-color-dark text-4 line-height-8 alternative-font-4 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget risus porta, tincidunt turpis at, interdum tortor. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </blockquote>
                                    <div class="testimonial-author">
                                        <p>
                                            <strong class="font-weight-bold text-5-5 negative-ls-1">- Jessica Belen</strong>
                                        <p class="text-color-dark mb-0">Atención al Cliente</p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>

    <footer id="footer" class="border-top-0 m-0 lazyload" data-bg-src="img/demos/adc/backgrounds/background-4.jpg" style="background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container pt-3">
            <div class="row justify-content-between align-items-center py-5 mb-3">
                <div class="col-auto mb-4 mb-lg-0">
                    <h2 class="font-weight-semibold text-color-light text-10 ls-0 mb-0">¿Estás listo para empezar?</h2>
                </div>
                <div class="col-auto">
                    <a href="/dashboard" class="btn btn-primary custom-btn-style-1 font-weight-medium btn-px-4 btn-py-2 text-4" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
                        <span class="text-color-light">Ingresar</span>
                    </a>
                </div>
            </div>
            <hr class="bg-color-light opacity-1 my-0">
            <div class="row pt-3 mt-5">
                <div class="col-lg-2 mb-4 mb-lg-0">
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <a href="{{route('welcome')}}" class="text-decoration-none">
                        <img src="img/logo_footer.png" class="img-fluid mb-4" width="123" height="33" alt="" />
                    </a>
                    <p class="text-3-5">
                        Somos la administradora de centrales líder en el mercado, impulsando la vanguardia en cada viaje. Nos dedicamos a ofrecerte una experiencia de viaje excepcional, donde la comodidad y la eficiencia son nuestra prioridad.
                    </p>
                    <ul class="social-icons social-icons-clean social-icons-clean-with-border social-icons-medium social-icons-icon-light">
                        <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook" data-cursor-effect-hover="fit"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="social-icons-twitter mx-2"><a href="http://www.twitter.com/" target="_blank" title="Twitter" data-cursor-effect-hover="fit"><i class="fab fa-x-twitter"></i></a></li>
                        <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin" data-cursor-effect-hover="fit"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <ul class="list list-icons list-icons-lg">
                        <li class="d-flex px-0 mb-1">
                            <img width="25" src="img/demos/business-consulting-3/icons/phone.svg" alt="Phone Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                            <a href="tel:8001234567" class="text-color-light font-weight-semibold text-3-4 ms-2">(800) 123-4567</a>
                        </li>
                        <li class="d-flex px-0 my-3">
                            <img width="25" src="img/demos/business-consulting-3/icons/email.svg" alt="Email Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                            <a href="mailto:contactorh@adcentrales.com" class="text-color-light font-weight-semibold text-3-4 ms-2">contactorh@adcentrales.com</a>
                        </li>
                        <li class="d-flex font-weight-semibold text-color-light px-0 mb-1">
                            <img width="25" src="img/demos/business-consulting-3/icons/map-pin.svg" alt="Location" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light me-2'}" />
                            Hilario Medina, León, Guanajuato 37000, México
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">

                    <h4 class="font-weight-bold text-5">Links</h4>
                    <ul class="list list-icons list-icons-sm">
                        <li>
                            <i class="fas fa-angle-right text-color-default"></i>
                            <a href="{{route('welcome')}}" class="link-hover-style-1 ms-1"> Inicio</a>
                        </li>
                        <li>
                            <i class="fas fa-angle-right text-color-default"></i>
                            <a href="{{route('about')}}" class="link-hover-style-1 ms-1">Acerca de Nosotros</a>
                        </li>
                        <li>
                            <i class="fas fa-angle-right text-color-default"></i>
                            <a href="{{route('modules')}}" class="link-hover-style-1 ms-1"> Módulos</a>
                        </li>
                        <li>
                            <i class="fas fa-angle-right text-color-default"></i>
                            <a href="{{route('questions')}}" class="link-hover-style-1 ms-1"> Preguntas Frecuentes</a>
                        </li>

                    </ul>
                </div>
                <div class="col-lg-2 mb-4 mb-lg-0">
                </div>
            </div>
        </div>
        <div class="footer-copyright container bg-transparent">
            <div class="row pb-5">
                <div class="col-lg-12 text-center m-0">
                    <hr class="bg-color-light opacity-1 mt-5 mb-4">
                    <p class="text-3-4">ADC Administradora de Centrales . © {{ date('Y') }}. Todos los derechos Reservados</p>
                    <a href="{{ route('aviso-privacidad') }}" class="text-decoration-underline text-color-light">Aviso de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Vendor -->
<script src="vendor/plugins/js/plugins.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Current Page Vendor and Views -->
<script src="js/views/view.contact.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('NOCAPTCHA_SITEKEY') }}"></script>
<script>
    console.log('Script cargado'); // Verifica que el script se ejecute
    const form = document.getElementById('form');
    if (!form) {
        console.error('Formulario no encontrado');
    } else {
        console.log('Formulario encontrado');
        form.addEventListener('submit', function(e) {
            console.log('Evento submit disparado');
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ env('NOCAPTCHA_SITEKEY') }}', { action: 'submit' })
                    .then(function(token) {
                        console.log('Token generado:', token);
                        document.getElementById('g-recaptcha-response').value = token;
                        console.log('Valor asignado a recaptcha_token:', document.getElementById('g-recaptcha-response').value);
                        e.target.submit();
                    })
                    .catch(function(error) {
                        console.error('Error al generar el token:', error);
                    });
            });
        });
    }
</script>
</body>
</html>
