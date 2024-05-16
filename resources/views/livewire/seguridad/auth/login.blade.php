<div class="row g-0 flex-fill">
    <div
        class="col-12 col-lg-6 col-xl-4 border-top-wide border-teal d-flex flex-column justify-content-center animate__animated animate__fadeIn animate__faster">
        <div class="container container-tight my-5 px-lg-5">
            <div class="text-center mb-4">
                <a class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('/media/logo-pg.webp') }}" height="200" alt="Logo"
                        class="rounded hide-theme-light">
                    <img src="{{ asset('/media/logo-pg.webp') }}" height="200" alt="Logo"
                        class="rounded hide-theme-dark">
                </a>
            </div>
            <h1 class="text-gray-800 text-center" style="font-weight: 700;">
                Bienvenido al Aula Virtual
            </h1>
            <h2 class="fs-2 text-center mb-5">
                Iniciar sesión
            </h2>
            <form wire:submit.prevent="iniciar_sesion" class="row g-3" autocomplete="off" novalidate>
                <div class="col-md-12">
                    <label class="form-label required">
                        Correo
                    </label>
                    <input id="correo" type="email"
                        class="form-control @error('correo') is-invalid @enderror"
                        wire:model.live="correo" placeholder="example@gmail.com" autocomplete="off">
                    @error('correo')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="contrasenia">
                        Contraseña <span class="text-danger">*</span>
                    </label>
                    <div class="input-group input-group-flat" x-data="{ modo_password: 'password' }">
                        <input id="contrasenia" x-bind:type="modo_password"
                            class="form-control @error('contrasenia') is-invalid @enderror" wire:model.live="contrasenia"
                            placeholder="********" autocomplete="off">
                        <span class="input-group-text @error('contrasenia') border border-danger @enderror">
                            <a style="cursor: pointer;" class="link-secondary"
                                x-on:click="modo_password == 'password' ? modo_password = 'text' : modo_password = 'password'">
                                <svg x-show="modo_password == 'text'" xmlns="http://www.w3.org/2000/svg" class="icon"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path
                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                                <svg x-show="modo_password == 'password'" xmlns="http://www.w3.org/2000/svg"
                                    class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                    <path
                                        d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                    <path d="M3 3l18 18" />
                                </svg>
                            </a>
                        </span>
                    </div>
                    @error('contrasenia')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-teal w-100">
                        Ingresar
                    </button>
                    @error('credenciales')
                        <span class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
        <div class="bg-cover h-100 min-vh-100" style="background-image: url({{ asset('/media/fondo-unu.webp') }})">
        </div>
    </div>
</div>