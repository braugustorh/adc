<!DOCTYPE html>
<html lang="en">
	<head>

		<!-- Basic -->
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
                                                        <a class="nav-link active" href="{{ route('contact') }}">
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

				<section class="section section-with-shape-divider page-header page-header-modern page-header-lg border-0 my-0 lazyload" data-bg-src="img/demos/business-consulting-3/backgrounds/background-5.jpg" style="background-size: cover; background-position: center;">
					<div class="container pb-5 my-3">
						<div class="row mb-4">
							<div class="col-md-12 align-self-center p-static order-2 text-center">
								<h1 class="font-weight-bold text-color-dark text-10">
                                    Directorio de Contacto
                                </h1>
							</div>
							<div class="col-md-12 align-self-center order-1">
								<ul class="breadcrumb d-block text-center">
									<li><a href="#">Inicio</a></li>
									<li class="active">Directorio</li>
								</ul>
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
                <div class="container mb-5 pt-3 mt-4">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-9 text-lg-5 text-xl-9 line-height-3 text-transform-none font-weight-semibold mb-4 mb-lg-3 mb-xl-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250">
                                Directorio RR.HH de CyT
                            </h2>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>OFICINA</th>
                                    <th>CENTRALES Y TERMINALES</th>
                                    <th>UBICACIÓN</th>
                                    <th>CORREO INSTITUCIONAL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td>COORDINACIÓN DE DESARROLLO ORGANIZACIONAL - ADC</td>
                                    <td>LEÓN</td>
                                    <td>contactorh@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td rowspan="6">
                                        <h1 class="font-weight-bold text-color-primary text-10 text-center">
                                            A
                                        </h1>
                                    </td>
                                    <td>ESTACIÓN CENTRAL DE AUTOBUSES LEÓN DE LOS ALDAMAS, SA DE CV</td>
                                    <td>LEÓN</td>
                                    <td>e.reyes@eca.adcentrales.com</td>
                                </tr>
                                <tr>

                                    <td>TERMINAL DE AUTOBUSES DE QUERETARO, SA DE CV.</td>
                                    <td>QUERÉTARO</td>
                                    <td>m.fernandez@taqro.com.mx</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL TERRESTRE POTOSINA</td>
                                    <td>SAN LUIS POTOSI</td>
                                    <td>rh@ttp.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES IRAPUATO SA DE CV.</td>
                                    <td>IRAPUATO</td>
                                    <td>a.perez@irapuato.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES TRESGUERRAS, SA DE CV.</td>
                                    <td>CELAYA</td>
                                    <td>a.palma@celaya.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>ARRENDAMIENTO ALTEÑA, SA DE CV.</td>
                                    <td>GUADALAJARA</td>
                                    <td>rh@gdl.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td rowspan="4">
                                        <h1 class="font-weight-bold text-color-primary text-10 text-center">
                                            B
                                        </h1>
                                    </td>
                                    <td>CENTRAL CAMIONERA NUEVO MILENIO DE GUADALAJARA SA DE CV.</td>
                                    <td>MILENIO</td>
                                    <td>gerencia@milenio.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES DE SAN JUAN DEL RIO, SA DE CV.</td>
                                    <td>SAN JUAN DEL RIO</td>
                                    <td>i.garcia@sjr.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES MANZANILLO, SA DE CV</td>
                                    <td>MANZANILLO</td>
                                    <td>rh@manzanillo.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES GUANAJUATO, SA DE CV</td>
                                    <td>GUANAJUATO</td>
                                    <td>gerencia@guanajuato.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td rowspan="19">
                                        <h1 class="font-weight-bold text-color-primary text-10 text-center">
                                            C</h1>
                                    </td>
                                    <td>CENTRAL DE AUTOBUSES ACAMBARO, SA DE CV.</td>
                                    <td>ACAMBARO</td>
                                    <td>gerencia@acambaro.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES CORTAZAR, SA DE CV</td>
                                    <td>CORTAZAR</td>
                                    <td>jc.quintana@cortazar.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES DE LA PIEDAD, SA DE CV</td>
                                    <td>LA PIEDAD</td>
                                    <td>gerencia@lapiedad.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES DE SALAMANCA, SA DE CV</td>
                                    <td>SALAMANCA</td>
                                    <td>gerencia@salamanca.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES LA BARCA, SA DE CV</td>
                                    <td>LA BARCA</td>
                                    <td>gerencia@labarca.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES OCOTLAN JALISCO, SA DE CV</td>
                                    <td>OCOTLAN</td>
                                    <td>m.tamayo@ocotlan.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES SALVATIERRA, SA DE CV</td>
                                    <td>SLAVATIERRA</td>
                                    <td>gerencia@salvatierra.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES SAN FELIPE GUANAJUATO SA DE CV</td>
                                    <td>SAN FELIPE</td>
                                    <td>terminal_sanfelipe@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES CORTAZAR SA DE CV. SUC DOLORES HIDALGO.</td>
                                    <td>DOLORES HIDALGO</td>
                                    <td>terminal_dolores@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES SAN MIGUEL DE ALLENDE, SA DE CV</td>
                                    <td>SAN MIGUEL ALLENDE</td>
                                    <td>terminal_sanmigueldeallende@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES SAN LUIS DE LA PAZ, SA DE CV</td>
                                    <td>SAN LUIS DE LA PAZ</td>
                                    <td>terminal_sanluisdelapaz@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>ESTACIÓN CENTRAL DE AUTOBUSES LEÓN DE LOS ALDAMAS, SA DE CV. SUC SILAO</td>
                                    <td>SILAO</td>
                                    <td>gerencia@silao.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES ZAPOTLAN, SA DE CV.</td>
                                    <td>ZAPOTLAN</td>
                                    <td>rh@zapotlan.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES DE JALPAN SA DE CV</td>
                                    <td>JALPAN</td>
                                    <td>terminal_jalpan@adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES TEQUISQUIAPAN, SA DE CV</td>
                                    <td>TEQUISQUIAPAN</td>
                                    <td>d.sandoval@tequis.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL ALMEALCENSE DE AUTOBUSES, SA DE CV.</td>
                                    <td>AMEALCO</td>
                                    <td>adelina@amealco.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>CENTRAL DE AUTOBUSES DE CADEREYTA, SA DE CV</td>
                                    <td>CADEREYTA</td>
                                    <td>central_cadereyta@cadereyta.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES MOROLEON, SA DE CV</td>
                                    <td>MOROLEON</td>
                                    <td>gerencia@moroleon.adcentrales.com</td>
                                </tr>
                                <tr>
                                    <td>TERMINAL DE AUTOBUSES URIANGATO, SA DE CV.</td>
                                    <td>URIANGATO</td>
                                    <td>gerencia@uriangato.adcentrales.com</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

				<section class="section section-height-3 bg-light border-0 pt-4 m-0 lazyload" data-bg-src="img/demos/business-consulting-3/backgrounds/background-6.jpg" style="background-size: 100%; background-repeat: no-repeat;">
					<div class="container py-4">
						<div class="row box-shadow-4 mx-3 mx-xl-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">
							<div class="col-lg-6 px-0">
								<div class="bg-light h-100">
									<div class="d-flex flex-column justify-content-center p-5 h-100 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
										<div class="pb-5 mb-4 mt-5 mt-lg-0">
											<div class="d-flex flex-column flex-md-row align-items-center justify-content-center pe-lg-4">
												<img width="105" height="105" src="img/demos/business-consulting-3/icons/map-pin.svg" alt="Location" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary mb-4 mb-md-0'}" style="width: 105px;" />
												<div class="text-center text-md-start ps-md-3">
													<h2 class="font-weight-semibold text-6 mb-1">adc Corporativo</h2>
													<p class="text-3-5 mb-0">Hilario Medina,<br>CP 37000<br>León, Guanajuato, Mex.</p>
												</div>
											</div>
										</div>
										<div class="row justify-content-center mb-5 mb-lg-0">
											<div class="col-auto text-center pt-4 mt-5">
												<h3 class="font-weight-semibold text-color-primary text-3-5 mb-0">Sugerencias</h3>
												<div class="d-flex">
													<img width="25" height="25" src="img/demos/business-consulting-3/icons/phone.svg" alt="Phone Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" />
													<a href="tel:8001234567" class="text-color-dark text-color-hover-primary font-weight-semibold text-decoration-none text-6 ms-2">800-123-4567</a>
												</div>
											</div>
											<div class="col-auto text-center pt-4 mt-5">
												<h3 class="font-weight-semibold text-color-primary text-3-5 mb-0">Correo Electrónico</h3>
												<div class="d-flex">
													<img width="25" height="25" src="img/demos/business-consulting-3/icons/email.svg" alt="Email Icon" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-primary'}" />
													<a href="mailto:contactorh@adcentrales.com " class="text-color-dark text-color-hover-primary text-decoration-underline font-weight-semibold text-5-5 wb-all ms-2">
                                                        contactorh@adcentrales.com
                                                    </a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 px-0">
								<div class="bg-dark h-100">
									<div class="text-center text-md-start p-5 h-100 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">
										<h2 class="text-color-light font-weight-medium mb-4 mt-5 mt-lg-0">Envía un mensaje</h2>
										<p class="text-3-5 font-weight-medium mb-4">Envíanos un mensaje directo al corporativo a través de nuestro formulario. </p>
                                        <div>
                                            @if(session()->has('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif

                                            @if(session()->has('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form wire:submit.prevent="submitForm"
                                                  class="contact-form form-style-4 form-placeholders-light form-errors-light mb-5 mb-lg-0">
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <input type="text" wire:model="name"
                                                               class="form-control"
                                                               data-msg-required="Escribe tu nombre completo."
                                                               maxlength="100"
                                                               class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                                               name="name"
                                                               placeholder="* Nombre Completo" required>
                                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <input type="text" wire:model="company"
                                                               data-msg-required="Ingresa la Terminal en la que laboras." maxlength="100"
                                                               class="form-control text-3 custom-border-color-grey-1 h-auto py-2" name="company"
                                                               placeholder="* Terminal en la que laboras" required>
                                                        @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <input type="email" wire:model="email"
                                                               data-msg-required="Escribe tu email address."
                                                               data-msg-email="Please enter a valid email address."
                                                               maxlength="100"
                                                               class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                                               name="email"
                                                               placeholder="* Correo Electrónico"
                                                               required>
                                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="form-group col">
                                                    <textarea wire:model="message"
                                                              maxlength="5000"
                                                              data-msg-required="Escribe tu mensaje."
                                                              class="form-control text-3 custom-border-color-grey-1 h-auto py-2"
                                                              name="message"
                                                              placeholder="* Mensaje"
                                                              rows="8" required></textarea>
                                                        @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" id="recaptchaToken" wire:model="recaptchaToken">
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <button type="submit"
                                                                class="btn btn-primary
                                                                custom-btn-style-1
                                                                font-weight-semibold
                                                                btn-px-4 btn-py-2
                                                                text-3-5"
                                                                data-loading-text="Loading..."
                                                                data-cursor-effect-hover="plus"
                                                                data-cursor-effect-hover-color="light">
                                                            <span>Enviar Mensaje</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
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
                        </div>
                    </div>
                </div>
            </footer>
		</div>

        <script
            src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY')??'6Lc8ywMrAAAAAFN8d0RhfmXkGIs8gPwYgvhRvx7h
' }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                grecaptcha.ready(function () {
                    grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY')??'6Lc8ywMrAAAAAFN8d0RhfmXkGIs8gPwYgvhRvx7h
' }}", { action: "submit" }).then(function (token) {
                        window.Livewire.dispatch('setRecaptchaToken', { token });
                    });
                });
            });
        </script>


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
