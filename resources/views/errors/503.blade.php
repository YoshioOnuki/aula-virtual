<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ $title ?? 'Aula Virtual' }}</title>

    <link rel="shortcut icon" href="{{ asset('/media/logo-unu.webp') }}" type="image/x-icon">

    <link href="{{ asset('assets/dist/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dist/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        .full-height {
            height: 100vh;
        }

        .empty {
            text-align: center;
        }
    </style>
    <script src="{{ asset('assets/dist/js/tabler.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1684106062') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

</head>

<body class=" border-top-wide border-teal d-flex flex-column">
    <script src="{{ asset('assets/dist/js/demo-theme.min.js?1684106062') }}"></script>

    <div class="d-flex justify-content-center align-items-center full-height">
        <div class="container-tight py-4">
            <div class="empty animate__animated animate__zoomInDown">
                <div class="empty-img">
                    <svg class="img" xmlns="http://www.w3.org/2000/svg" height="256" fill="none" viewBox="0 0 800 600">
                        <style>
                            :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-computer-fix-a {
                                fill: black;
                                opacity: 0.07;
                            }

                            :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-computer-fix-b {
                                fill: #1A2030;
                            }

                            :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-computer-fix-c {
                                fill: #232B41;
                            }

                            :where(.theme-dark, [data-bs-theme="dark"]) .tblr-illustrations-computer-fix-d {
                                fill: #454C5E;
                            }

                            @media (prefers-color-scheme: dark) {
                                .tblr-illustrations-computer-fix-a {
                                    fill: black;
                                    opacity: 0.07;
                                }

                                .tblr-illustrations-computer-fix-b {
                                    fill: #1A2030;
                                }

                                .tblr-illustrations-computer-fix-c {
                                    fill: #232B41;
                                }

                                .tblr-illustrations-computer-fix-d {
                                    fill: #454C5E;
                                }
                            }

                        </style>
                        <path d="M165.042 305.17C165.042 347.031 209.306 377.394 228.857 411.189C249.036 446.056 253.885 499.359 288.752 519.524C322.562 539.075 370.673 517.207 412.534 517.207C454.395 517.207 502.506 539.075 536.301 519.524C571.168 499.359 576.017 446.056 596.196 411.189C615.747 377.394 660.011 347.031 660.011 305.17C660.011 263.309 615.747 232.961 596.196 199.166C576.017 164.298 571.168 110.996 536.301 90.8302C502.506 71.2798 454.381 93.1471 412.534 93.1471C370.687 93.1471 322.562 71.2798 288.752 90.8302C253.885 110.996 249.036 164.298 228.857 199.166C209.306 232.961 165.042 263.323 165.042 305.17Z" fill="#F7F8FC" class="tblr-illustrations-computer-fix-a"></path>
                        <path d="M375.492 479.923C470.481 479.923 547.485 476.824 547.485 473.001C547.485 469.178 470.481 466.079 375.492 466.079C280.503 466.079 203.5 469.178 203.5 473.001C203.5 476.824 280.503 479.923 375.492 479.923Z" fill="#A6A9B3" class="tblr-illustrations-computer-fix-b"></path>
                        <path d="M511.988 174.667C493.855 167.122 474.216 163.9 454.624 165.256L456.64 177.084L511.988 174.667Z" fill="#0455A4" style="fill: #0455A4; fill: var(--tblr-illustrations-teal, var(--tblr-teal, #0455A4));"></path>
                        <path d="M518.452 301.638L572.584 329.197L591.949 299.006L602.918 281.844C608.639 272.891 617.062 260.034 627.674 244.159C626.096 241.199 624.176 238.434 621.954 235.921C616.989 230.419 610.739 226.233 603.762 223.736H603.633C599.858 222.306 595.996 221.019 592.192 219.674C585.755 217.369 579.457 214.695 573.328 211.665C568.623 209.377 563.545 206.66 558.154 203.428C555.15 210.807 552.161 218.187 549.187 225.567C543.466 239.868 537.697 254.132 531.881 268.357C527.419 279.465 522.943 290.558 518.452 301.638Z" fill="#DADBE0"></path>
                        <path d="M573.328 211.665L580.908 225.338L581.866 225.567C589.204 227.065 596.817 226.429 603.805 223.736H603.676C599.9 222.306 596.039 221.019 592.235 219.674C585.784 217.371 579.471 214.697 573.328 211.665Z" fill="#FFCB9D" style="fill: #FFCB9D; fill: var(--tblr-illustrations-skin, #FFCB9D);"></path>
                        <path d="M627.674 244.216C617.062 260.091 608.696 272.948 602.918 281.901C601.087 284.762 599.757 286.807 594.509 295.016L591.949 299.006L582.738 313.308L572.584 329.14L518.466 301.623C522.928 290.563 527.405 279.494 531.896 268.415L549.186 225.638C549.286 225.409 549.372 225.181 549.472 224.966C551.379 220.132 553.329 215.303 555.322 210.478C556.275 208.152 557.229 205.816 558.182 203.471C561.171 205.287 564.089 206.917 566.878 208.405C569.109 209.606 571.268 210.707 573.356 211.737C579.485 214.732 585.778 217.377 592.206 219.66C596.01 221.004 599.872 222.234 603.647 223.722H603.776C604.648 224.079 605.521 224.423 606.365 224.823C612.359 227.307 617.709 231.121 622.011 235.978C624.209 238.497 626.11 241.261 627.674 244.216Z" fill="#0455A4" style="fill: #0455A4; fill: var(--tblr-illustrations-teal, var(--tblr-teal, #0455A4));"></path>
                        <path d="M600.816 220.246C592.321 224.537 585.441 224.852 580.507 224.165C580.221 224.165 579.95 224.094 579.678 224.036L572.069 212.595C578.204 212.59 584.3 213.555 590.132 215.455C593.844 216.693 597.423 218.298 600.816 220.246Z" fill="#FFCB9D" style="fill: #FFCB9D; fill: var(--tblr-illustrations-skin, #FFCB9D);"></path>
                        <path d="M191.729 429.895L559.226 429.895C571.011 429.895 580.564 420.342 580.564 408.557V198.408C580.564 186.623 571.011 177.07 559.226 177.07L191.729 177.07C179.945 177.07 170.391 186.623 170.391 198.408V408.557C170.391 420.342 179.945 429.895 191.729 429.895Z" fill="white" class="tblr-illustrations-computer-fix-c"></path>
                        <path d="M585.585 197.736C585.395 190.871 582.538 184.35 577.619 179.557C572.701 174.764 566.108 172.076 559.241 172.064H191.687C184.702 172.072 178.006 174.849 173.067 179.788C168.128 184.727 165.35 191.423 165.343 198.408V408.643C165.35 415.628 168.128 422.324 173.067 427.263C178.006 432.201 184.702 434.979 191.687 434.987H326.008V443.94C324.578 453.679 318.042 456.425 313.466 457.126H262.537C261.503 457.13 260.512 457.542 259.781 458.274C259.049 459.005 258.637 459.996 258.633 461.03V465.55C258.637 466.584 259.049 467.575 259.781 468.306C260.512 469.038 261.503 469.45 262.537 469.454H488.504C489.017 469.454 489.525 469.353 489.999 469.157C490.472 468.961 490.903 468.673 491.265 468.31C491.628 467.948 491.915 467.517 492.112 467.044C492.308 466.57 492.409 466.062 492.409 465.55V461.03C492.409 460.517 492.308 460.01 492.112 459.536C491.915 459.062 491.628 458.632 491.265 458.269C490.903 457.907 490.472 457.619 489.999 457.423C489.525 457.227 489.017 457.126 488.504 457.126H437.476C432.899 456.425 426.306 453.665 424.933 443.868V434.915H559.241C566.226 434.908 572.924 432.13 577.865 427.192C582.806 422.254 585.587 415.557 585.599 408.571V198.336C585.599 198.179 585.599 197.964 585.585 197.736ZM575.573 408.571C575.57 412.898 573.849 417.047 570.79 420.106C567.73 423.166 563.582 424.886 559.255 424.89H191.701C187.374 424.886 183.226 423.166 180.166 420.106C177.107 417.047 175.386 412.898 175.383 408.571V198.336C175.386 194.01 177.107 189.861 180.166 186.802C183.226 183.742 187.374 182.022 191.701 182.018H559.255C561.484 182.012 563.691 182.469 565.734 183.362C568.656 184.626 571.144 186.717 572.892 189.378C574.641 192.039 575.573 195.153 575.573 198.336V408.571Z" fill="#232B41" class="tblr-illustrations-computer-fix-d"></path>
                        <path d="M211.108 222.706L443.454 222.706C444.497 222.706 445.342 221.861 445.342 220.819V214.798C445.342 213.755 444.497 212.91 443.454 212.91L211.108 212.91C210.066 212.91 209.22 213.755 209.22 214.798V220.819C209.22 221.861 210.066 222.706 211.108 222.706Z" fill="#0455A4" style="fill: #0455A4; fill: var(--tblr-illustrations-teal, var(--tblr-teal, #0455A4));"></path>
                        <path d="M211.094 314.981H252.111C253.146 314.981 253.985 314.142 253.985 313.108V307.058C253.985 306.023 253.146 305.184 252.111 305.184H211.094C210.059 305.184 209.22 306.023 209.22 307.058V313.108C209.22 314.142 210.059 314.981 211.094 314.981Z" fill="#DADBE0"></path>
                        <path d="M211.809 279.856H368.97C370.4 279.856 371.559 278.697 371.559 277.267V250.595C371.559 249.165 370.4 248.006 368.97 248.006L211.809 248.006C210.379 248.006 209.22 249.165 209.22 250.595V277.267C209.22 278.697 210.379 279.856 211.809 279.856Z" fill="#A7AAB3"></path>
                        <path d="M389.479 335.733L382.271 326.78L363.822 341.611L346.56 320.144L331.586 332.2L348.848 353.667L330.399 368.498L337.593 377.465L356.042 362.62L373.304 384.087L388.292 372.031L371.03 350.564L389.479 335.733Z" fill="#0455A4" style="fill: #0455A4; fill: var(--tblr-illustrations-teal, var(--tblr-teal, #0455A4));"></path>
                        <path d="M591.934 268.701C593.522 258.689 602.961 233.776 606.393 224.895C605.55 224.494 604.677 224.151 603.805 223.793H603.676C597.784 223.936 594.695 223.45 594.451 222.363C594.266 221.548 595.567 220.418 598.356 218.945C595.969 217.727 593.498 216.68 590.962 215.813C589.216 215.204 587.44 214.684 585.642 214.254L585.413 309.389C587.615 305.957 589.818 302.539 592.006 299.106L594.566 295.116C592.635 286.034 590.919 275.094 591.934 268.701ZM485.401 254.857C484.8 254.942 484.114 259.376 486.288 262.208C486.835 262.909 487.534 263.476 488.333 263.867C487.189 258.861 486.002 254.785 485.401 254.857ZM507.354 307.487C505.774 306.55 504.119 305.747 502.406 305.084C503.966 306.056 505.625 306.862 507.354 307.487ZM469.283 332.115L465.765 355.569L469.583 349.491C469.14 343.71 469.039 337.908 469.283 332.115ZM514.004 331.385C514.763 329.722 515.32 327.975 515.663 326.179C506.08 322.786 496.693 318.861 487.546 314.423C485.44 321.176 482.706 327.717 479.38 333.959L469.583 349.534C469.755 351.293 469.984 353.038 470.298 354.711C472.043 364.122 476.219 370.586 479.408 375.535C485.661 385.147 494.013 393.215 503.836 399.132C530.306 400.116 556.093 390.607 575.588 372.674V364.994L514.004 331.385Z" fill="black" opacity="0.1"></path>
                        <path d="M514.376 314.638C512.764 311.667 510.325 309.227 507.354 307.616C505.625 306.99 503.966 306.185 502.406 305.213L502.148 305.084C502.148 305.084 502.248 305.084 502.406 305.213C504.119 305.875 505.774 306.679 507.354 307.616C507.997 307.787 508.527 307.802 508.784 307.53C510.1 306.243 503.478 300.451 502.005 290.783C501.633 288.251 500.761 282.502 504.05 277.182C508.169 270.517 515.935 269.244 517.422 269.015C511.358 267.019 505.07 265.785 498.701 265.34C494.411 265.039 490.835 265.182 488.318 263.91C489.348 268.372 490.349 273.549 490.864 277.153C492.515 289.684 491.377 302.426 487.532 314.466C496.679 318.904 506.065 322.829 515.649 326.222C516.477 322.324 516.031 318.263 514.376 314.638ZM585.584 175.096V229.042C582.59 228.905 579.63 228.351 576.789 227.397C565.562 223.564 557.567 213.668 557.567 202.069C557.567 190.47 565.562 180.616 576.789 176.741C579.63 175.787 582.59 175.233 585.584 175.096Z" fill="black" opacity="0.1"></path>
                        <path d="M585.57 222.935L609.483 216.128L613.501 223.278L588.974 239.868C587.816 237.194 586.643 234.505 585.484 231.817C585.556 228.827 585.556 225.967 585.57 222.935Z" fill="#DADBE0"></path>
                        <path d="M585.584 175.096V229.042C582.59 228.905 579.63 228.351 576.789 227.397L575.559 226.954V198.351C575.558 195.167 574.626 192.053 572.878 189.392C571.13 186.732 568.641 184.641 565.719 183.377C568.431 180.786 571.61 178.733 575.087 177.327C575.645 177.098 576.217 176.884 576.789 176.683C579.633 175.749 582.593 175.215 585.584 175.096Z" fill="black" opacity="0.3"></path>
                        <path d="M610.198 137.454C611.056 141.973 612.186 148.609 613.358 156.818C613.587 158.62 613.816 160.194 613.902 160.737C614.881 169.779 614.722 178.908 613.43 187.91C613.144 189.698 612.843 191.4 612.429 193.073C611.299 197.707 600.287 205.258 587.072 209.706C582.519 211.261 577.817 212.34 573.042 212.924C558.182 214.712 548.414 204.586 548.343 195.762C548.293 193.608 548.896 191.488 550.073 189.684C552.13 186.006 553.496 181.983 554.106 177.813C555.126 172.287 555.748 166.695 555.966 161.08C556.166 157.877 556.151 155.789 556.151 155.789L567.593 140.214L601.845 132.348C602.761 138.197 605.178 141.844 607.066 141.787C608.953 141.73 609.955 138.212 610.198 137.454Z" fill="#FFCB9D" style="fill: #FFCB9D; fill: var(--tblr-illustrations-skin, #FFCB9D);"></path>
                        <path d="M610.198 137.454C611.041 141.973 612.185 148.609 613.373 156.818C613.587 158.62 613.816 160.208 613.887 160.737C614.877 169.778 614.728 178.907 613.444 187.91C611.07 187.716 608.754 187.071 606.622 186.008C604.293 184.813 602.223 183.171 600.53 181.174C598.789 179.022 597.399 176.608 596.411 174.023C595.671 172.382 595.036 170.696 594.509 168.975C582.401 176.336 568.178 179.433 554.106 177.77C555.126 172.244 555.747 166.652 555.965 161.037C556.166 157.834 556.151 155.731 556.151 155.731L567.593 140.171L601.845 132.348C602.761 138.197 605.178 141.844 607.065 141.773C608.953 141.701 610.026 138.212 610.269 137.482" fill="black" opacity="0.1"></path>
                        <path d="M616.147 143.804C617.621 150.946 616.333 158.382 612.543 164.613C611.699 165.705 610.934 166.857 610.255 168.059C608.586 171.497 607.8 175.297 607.967 179.115C605.963 177.555 604.47 175.434 603.676 173.022C602.575 169.318 602.618 161.996 602.475 161.009V160.408C602.475 160.079 602.389 159.636 602.275 158.778C601.977 156.941 601.562 155.126 601.03 153.343C601.023 153.249 600.988 153.16 600.93 153.086C593.479 160.322 571.769 178.829 552.304 169.962C549.27 168.595 546.452 166.793 543.938 164.613C543.696 164.444 543.479 164.242 543.294 164.012C542.682 163.466 542.104 162.884 541.564 162.267L541.406 162.11C540.013 160.506 538.892 158.685 538.088 156.718L537.488 155.889C537.211 155.006 537.005 154.102 536.873 153.186C536.555 149.566 537.5 145.948 539.547 142.946C543.251 137.068 549.701 132.62 553.105 130.303C566.291 121.136 588.001 114.728 603.505 124.983C607.42 127.703 610.643 131.303 612.915 135.494C614.324 138.117 615.359 140.923 615.99 143.832" fill="#232B41" class="tblr-illustrations-computer-fix-d"></path>
                        <path d="M600.744 153.028C593.293 160.265 571.583 178.771 552.118 169.904C549.084 168.538 546.266 166.736 543.752 164.556C543.51 164.387 543.293 164.185 543.108 163.955C542.496 163.409 541.918 162.827 541.378 162.21L541.22 162.053C539.83 160.447 538.709 158.626 537.902 156.661C542.634 159.548 547.809 161.635 553.219 162.839C580.007 168.674 602.146 148.724 605.678 145.534L605.95 145.291C604.428 148.012 602.707 150.618 600.801 153.086" fill="black" opacity="0.5"></path>
                        <path d="M483.942 177.727C483.944 179.167 483.81 180.604 483.542 182.018H457.484C457.216 180.604 457.082 179.167 457.083 177.727C457.072 175.8 457.298 173.879 457.756 172.007H483.284C483.729 173.881 483.95 175.801 483.942 177.727Z" fill="black" opacity="0.3"></path>
                        <path d="M466.422 169.089C467.695 170.426 468.769 171.938 469.612 173.58C472.744 179.386 472.315 185.679 468.053 189.169C462.618 193.559 453.165 191.729 446.872 185.064C446.186 184.326 445.55 183.543 444.97 182.719C440.493 176.412 440.451 168.875 445.256 164.999C450.633 160.594 460.144 162.425 466.422 169.089Z" fill="#FFCB9D" style="fill: #FFCB9D; fill: var(--tblr-illustrations-skin, #FFCB9D);"></path>
                        <path d="M466.422 169.089C467.695 170.426 468.769 171.938 469.612 173.58C469.011 173.98 468.468 174.338 467.881 174.695C460.144 179.344 455.167 178.385 446.114 182.161C445.722 182.324 445.34 182.51 444.97 182.719C440.493 176.412 440.451 168.875 445.256 164.999C450.633 160.594 460.144 162.425 466.422 169.089Z" fill="black" opacity="0.1"></path>
                        <path d="M585.599 343.37V364.122L575.587 372.703V346.831L585.384 342.212L585.599 343.37Z" fill="black" opacity="0.15"></path>
                        <path d="M520.025 263.695C518.559 268.03 515.781 271.802 512.076 274.488C508.37 277.173 503.921 278.64 499.345 278.683L483.141 326.766L476.205 347.274L473.273 355.927C476.717 358.617 479.284 362.269 480.65 366.42C482.016 370.571 482.119 375.034 480.946 379.243C479.772 383.452 477.376 387.219 474.059 390.064C470.743 392.91 466.657 394.707 462.318 395.228L469.04 375.377C469.299 374.598 469.24 373.747 468.876 373.011C468.512 372.274 467.872 371.711 467.095 371.444L454.967 367.34C454.187 367.08 453.337 367.139 452.6 367.503C451.864 367.867 451.301 368.508 451.034 369.285L444.326 389.135C441.191 386.09 439.031 382.181 438.122 377.905C437.212 373.629 437.594 369.179 439.219 365.121C440.843 361.063 443.637 357.579 447.246 355.112C450.855 352.644 455.115 351.305 459.486 351.265L462.347 342.941L469.412 322.046L485.573 274.021C482.129 271.331 479.561 267.679 478.195 263.528C476.829 259.377 476.726 254.914 477.9 250.705C479.073 246.495 481.47 242.729 484.786 239.883C488.102 237.038 492.189 235.24 496.528 234.72L489.806 254.571C489.673 254.956 489.619 255.365 489.645 255.772C489.671 256.179 489.778 256.577 489.959 256.942C490.14 257.308 490.391 257.634 490.699 257.902C491.006 258.17 491.364 258.375 491.751 258.504L503.864 262.608C504.644 262.868 505.494 262.809 506.231 262.445C506.967 262.08 507.53 261.44 507.797 260.663L514.519 240.812C517.507 243.715 519.611 247.406 520.585 251.457C521.56 255.507 521.366 259.751 520.025 263.695Z" fill="#A7AAB3"></path>
                        <path d="M483.141 326.766L476.205 347.274C473.637 346.92 471.106 346.341 468.639 345.544C466.472 344.831 464.359 343.961 462.318 342.941L469.383 322.046C471.541 322.405 473.668 322.926 475.747 323.605C478.306 324.422 480.782 325.48 483.141 326.766Z" fill="black" opacity="0.1"></path>
                        <path d="M477.421 302.581C474.667 302.666 471.941 303.148 469.326 304.012C459.915 306.872 453.765 314.023 454.638 322.175C455.782 332.544 467.738 340.524 481.396 340.052C482.907 339.986 484.412 339.823 485.901 339.566C497.257 337.549 505.209 329.555 504.179 320.459C503.063 310.147 491.05 302.11 477.421 302.581Z" fill="#FFCB9D" style="fill: #FFCB9D; fill: var(--tblr-illustrations-skin, #FFCB9D);"></path>
                        <path d="M477.42 302.581C474.667 302.666 471.941 303.148 469.326 304.012C469.555 305.07 469.755 306.014 470.012 307.001C473.344 320.058 479.623 324.263 485.244 337.764C485.499 338.35 485.719 338.952 485.901 339.566C497.257 337.549 505.209 329.555 504.179 320.459C503.063 310.147 491.05 302.11 477.42 302.581Z" fill="black" opacity="0.1"></path>
                        <path d="M640.36 287.951C638.93 310.59 624.628 332.93 601.002 350.178C579.177 366.095 549.387 377.694 514.391 381.184C508.167 370.155 502.23 358.967 496.585 347.632C494.726 343.928 492.909 340.181 491.079 336.362C483.928 321.46 477.664 307.044 472.129 293.271C487.689 298.377 551.975 318.442 589.932 302.152C596.811 299.206 610.541 293.4 612.486 282.13C613.048 278.08 612.317 273.956 610.398 270.345C608.798 267.347 607.829 264.053 607.55 260.666C607.271 257.279 607.688 253.871 608.776 250.652C609.864 247.432 611.599 244.469 613.876 241.946C616.152 239.422 618.92 237.392 622.011 235.978C640.46 260.177 640.861 279.87 640.36 287.951Z" fill="#0455A4" style="fill: #0455A4; fill: var(--tblr-illustrations-teal, var(--tblr-teal, #0455A4));"></path>
                        <path d="M601.002 350.178C579.177 366.095 549.387 377.694 514.39 381.184C511.347 375.792 508.372 370.361 505.466 364.894C501.376 357.2 497.519 349.634 493.896 342.197C505.942 349.292 519.121 354.256 532.854 356.871C555.749 361.042 579.355 358.723 601.002 350.178Z" fill="black" opacity="0.1"></path>
                    </svg>
                </div>
                <p class="empty-title">
                    Temporalmente fuera de servicio por mantenimiento
                </p>
                <p class="empty-subtitle text-secondary">
                    Disculpe las molestias, pero estamos realizando tareas de mantenimiento en este momento.
                    ¡Pronto volveremos a estar en línea!
                </p>
                {{-- <div class="empty-action">
                    <a href="{{ route('inicio') }}" class="btn btn-secondary" id="backButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l6 6"></path>
                            <path d="M5 12l6 -6"></path>
                        </svg>
                        Ir al Inicio
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/dist/js/tabler.min.js?1720208459') }}" defer=""></script>
    <script src="{{ asset('assets/dist/js/demo.min.js?1720208459') }}" defer=""></script>

    <script>
        document.getElementById('backButton').addEventListener('click', function(event) {
            event.preventDefault();
            var url = this.href;

            fetch('/validate-url?url=' + encodeURIComponent(url))
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        window.location.href = url;
                    } else {
                        console.error('Error:', data.message);
                        window.location.href = '/';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = '/';
                });
        });
    </script>

</body>
</html>
