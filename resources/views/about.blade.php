<!DOCTYPE html>
<html lang="en">
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>ADC Plataforma | SEDyCO</title>

        <meta name="keywords" content="ADC - SEDYCO" />
        <meta name="description" content="Plataforma para la Evaluación al Desempeño y el Clima Organizacional">
        <meta name="author" content="NetInnfode">

        <title>ADC Plataforma | SEDYCO</title>


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
                <div class="header-body border-top-0">
                    <div class="header-top header-top-default header-top-borders border-bottom-0 bg-color-light">
                        <div class="container">
                            <div class="header-row">
                                <div class="header-column justify-content-between">
                                    <div class="header-row">
                                        <nav class="header-nav-top w-100 w-md-50pct w-xl-100pct">
                                            <ul class="nav nav-pills d-inline-flex custom-header-top-nav-background pe-5">
                                                <li class="nav-item py-2 d-inline-flex z-index-1">

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
                                                        <a class="nav-link" href="{{route('welcome')}}">
                                                            Inicio
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link active" href="{{ route('about') }}">
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

				<section class="section page-header page-header-modern page-header-lg border-0 my-0 lazyload" data-bg-src="img/demos/business-consulting-3/backgrounds/background-5.jpg" style="background-size: cover; background-position: center;">
					<div class="container my-2">
						<div class="row">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="font-weight-bold text-color-dark text-10">Acerca de Nosotros</h1>
							</div>
							<div class="col-md-12 align-self-center order-1">
								<ul class="breadcrumb d-block text-center">
									<li><a href="{{route('welcome')}}">Inicio</a></li>
									<li class="active">Acerca de Nosotros</li>
								</ul>
							</div>
						</div>
                    </div>
                    <div class="container-fluid pt-2 mt-2 mb-2">
                        <div class="row">
                            <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">
                                <div class="owl-carousel owl-theme carousel-center-active-item custom-carousel-vertical-center-items custom-dots-style-1"
                                     data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 3}, '768': {'items': 4}, '992': {'items': 5}, '1200': {'items': 6}, '1600': {'items': 7}},'loop': true, 'nav': true, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': true}">

                                    <div class="text-center mx-2">
                                        <img class="d-inline-block img-fluid" src="img/centrales/central-1.png" alt="" style="max-width: 360px;" />
                                    </div>
                                    <div class="text-center mx-2">
                                        <img class="d-inline-block img-fluid" src="img/centrales/central-2.jpeg" alt="" style="max-width: 360px;" />
                                    </div>
                                    <div class="text-center mx-2">
                                        <img class="d-inline-block img-fluid" src="img/centrales/central-4.jpeg" alt="" style="max-width: 360px;" />
                                    </div>
                                    <div class="text-center mx-2">
                                        <img class="d-inline-block img-fluid" src="img/centrales/central-17.jpg" alt="" style="max-width: 360px;" />
                                    </div>
                                    <div class="text-center mx-2">
                                        <img class="d-inline-block img-fluid" src="img/centrales/central-18.jpg" alt="" style="max-width: 360px;" />
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
				</section>

				<section class="section section-with-shape-divider bg-color-grey border-0 pb-5 m-0">

					<div class="container pb-5">
						<div class="row align-items-center py-2 my-5 mb-lg-0 my-xl-5">
							<div class="col-lg-12 mb-5 mb-lg-0">
								<h2 class="text-9 text-center line-height-3 text-transform-none font-weight-semibold mb-4 appear-animation"
									data-appear-animation="fadeInUpShorter" data-appear-animation-delay="150">
									Nuestra Historia
								</h2>
								<p class="text-3-5 font-weight-medium mb-5 appear-animation text-center" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="350">
                                    Conoce el trayecto que grupo <strong>Flecha Amarilla</strong> ha recorrido desde sus inicios hasta consolidarse como un referente en terminales terrestres.
								</p>
								<img src="img/demos/business-consulting-3/historia.webp" class="img-fluid" alt="" />
							</div>
						</div>
					</div>
					<div class="shape-divider shape-divider-bottom shape-divider-reverse-x" style="height: 123px;">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 123" preserveAspectRatio="xMinYMin">
							<polygon fill="#F3F3F3" points="0,90 221,60 563,88 931,35 1408,93 1920,41 1920,-1 0,-1 "/>
							<polygon fill="#FFFFFF" points="0,75 219,44 563,72 930,19 1408,77 1920,25 1920,-1 0,-1 "/>
						</svg>
					</div>
				</section>

				<div class="container pt-3 mt-4">
					<div class="row">
						<div class="col">
							<h2 class="text-9 text-lg-5 text-xl-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">
								En adc, brindamos las estrategias más avanzadas para ofrecer una experiencia superior a los pasajeros.
							</h2>
							{{-- <h5 class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="350">Visión</h5>--}}
							<p class="text-3-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
								En ADC, tenemos como <strong>misión:</strong> <strong>brindar una estadía placentera para cada viajero</strong>. Trabajamos incansablemente para gestionar de manera eficiente y eficaz las terminales de autobuses, creando espacios funcionales y seguros que inviten a la relajación y el confort.
							{{-- <h5 class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">Misión</h5>--}}
							<p class="text-3-5  appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
								Nuestra <strong>visión</strong> es clara: <strong> seguir siendo una organización sustentable ofreciendo una gestión de operación funcional y eficiente para nuestros viajeros. Generando un entorno colaborativo y de networking con las compañías presentes en nuestras instalaciones de terminales terrestres, enriqueciendo así la experiencia de viaje.</strong>
							</p>
							<p class="text-3-5  mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="950">
								Nuestros <strong>valores</strong> son parte fundamental de nuestra visión, valores como: <strong>la honestidad, lealtad, pasión, colaboración, compromiso y seguridad</strong>; nos impulsan a desarrollar soluciones innovadoras y la optimización constante de nuestros procesos, buscando superar las expectativas de nuestros clientes, haciendo de cada visita a nuestras terminales un momento agradable y memorable.
							</p>
							<div class="row row-gutter-sm align-items-center pb-3 mb-5">
								<div class="col-lg-6 col-xl-7">
									<div class="row flex-xl-nowrap align-items-center mb-4 mb-lg-0">
										<div class="col-sm-auto mb-4 mb-sm-0">
											<div class="d-flex appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1000">
												<img width="63" height="63" src="img/demos/business-consulting-3/icons/label.svg" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'd-lg-none d-xl-block'}" />
												<span class="text-3 font-weight-bold text-color-dark pt-2 ms-3">
													<strong class="d-block font-weight-bold text-10 mb-0">+40mil</strong>
													Clientes Satisfechos
												</span>
											</div>
										</div>
										<div class="col-sm-7 col-md-8">
											<blockquote class="custom-blockquote-style-1 m-0 pt-1 pb-2 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1200">
												<p class="mb-0">Seguimos trabajando para brindar la mejor experiencia de servicio. </p>
											</blockquote>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-xl-5">
									<div class="row row-gutter-sm align-items-center">
										<div class="col-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1400">
											<a href="" class="btn btn-primary custom-btn-style-1 font-weight-semibold btn-px-3 btn-py-2 text-3-5" data-cursor-effect-hover="plus" data-cursor-effect-hover-color="light">
												<span>Directorio</span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row row-gutter-sm">
						<div class="col-sm-6 mb-4 mb-sm-0">
							<img src="img/centrales/central-4.jpeg" class="img-fluid box-shadow-5 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="800" alt="" />
						</div>
						<div class="col-6 col-sm-3">
							<img src="img/centrales/vertical-central.jpg" class="img-fluid box-shadow-5 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="600" alt="" />
						</div>
						<div class="col-6 col-sm-3">
							<img src="img/centrales/central-2.jpeg" class="img-fluid box-shadow-5 mb-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200" alt="" />
							<img src="img/centrales/central-14.jpeg" class="img-fluid box-shadow-5 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="400" alt="" />
						</div>
					</div>
				</div>

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

	</body>
</html>
