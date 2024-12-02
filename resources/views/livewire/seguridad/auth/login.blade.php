<div>
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-teal
            d-flex flex-column justify-content-center animate__animated animate__fadeIn">
            <div class="container container-tight my-5 px-lg-6">
                <div class="text-center mb-4">
                    <a class="navbar-brand navbar-brand-autodark animate__animated animate__backInDown ">
                        <picture>
                            <img src="{{ asset('/media/logo-pg.webp') }}" height="160" alt="Logo"
                                class="rounded">
                        </picture>
                    </a>
                </div>
                <h2 class="h3 text-center mb-3 text-uppercase animate__animated animate__flipInX animate__delay-1s">
                    Bienvenido al Aula Virtual
                </h2>
                <form wire:submit.prevent="iniciar_sesion"
                    class="row g-3 animate__animated animate__fadeIn animate__slow" autocomplete="off" novalidate>

                    @if($estado_bloqueo)
                    <div class="text-end mt-4 position-relative" wire:poll.1000ms="update_tiempo_restante">
                        <span
                            class="badge bg-red-lt p-2 text-center fw-bold animate__animated {{ $tiempo_restante === 0 || $tiempo_restante === null ? 'animate__bounceOut' : 'animate__bounceIn' }}">
                            Tiempo restante:
                            {{ floor($tiempo_restante / 60) }}:{{ $tiempo_restante % 60 < 10 ? '0' : '' }}{{
                                $tiempo_restante % 60 }} </span>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <label class="form-label required">
                            Correo
                        </label>
                        <input id="correo" type="email" class="form-control @error('correo') is-invalid @enderror"
                            wire:model.lazy="correo" placeholder="example@unu.edu.pe" autocomplete="off">
                        @error('correo')
                        <span class="form-text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label required" for="contrasenia">
                            Contraseña
                        </label>
                        <div class="input-group input-group-flat" x-data="{ modo_password: 'password' }">
                            <input id="contrasenia" x-bind:type="modo_password"
                                class="form-control @error('contrasenia') is-invalid @enderror"
                                wire:model.lazy="contrasenia" placeholder="********" autocomplete="off">
                            <span class="input-group-text @error('contrasenia') border border-danger @enderror">
                                <a style="cursor: pointer;" class="link-secondary"
                                    x-on:click="modo_password == 'password' ? modo_password = 'text' : modo_password = 'password'">
                                    <svg x-show="modo_password == 'text'" xmlns="http://www.w3.org/2000/svg"
                                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    <svg x-show="modo_password == 'password'" xmlns="http://www.w3.org/2000/svg"
                                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
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

                        <div class="form-text text-end mt-2">
                            <a href="" class="link-primary">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button class="btn btn-teal w-100" type="submit" wire:loading.attr="disabled"
                            wire:target="iniciar_sesion" {{ $tiempo_restante !==null ? 'disabled' : '' }}>
                            <span wire:loading.remove wire:target="iniciar_sesion">Iniciar Sesión</span>
                            <span wire:loading wire:target="iniciar_sesion">
                                <div class="spinner-border spinner-border-sm" role="status"></div>
                            </span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <picture>
                <div class="bg-cover h-100 min-vh-100 animate__animated animate__fadeIn animate__slow"
                    style="background-image: url({{ asset('/media/fondo-unu.webp') }})">
                </div>
            </picture>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('estado-bloqueo', () => {
                setTimeout(() => {
                    @this.call('cerrar_bloqueo');
                    console.log('Actualizando tiempo restante');
                }, 1000);
            });
        });
</script>
@endpush
