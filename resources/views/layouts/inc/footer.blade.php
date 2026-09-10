<footer class="footer-pink">
    <div class="container py-5">
        <div class="row g-4 align-items-center justify-content-center">
            <!-- Brand -->
            <div class="col-lg-7 col-md-12 text-center text-lg-start">
                <h5 class="fw-bold mb-2" style="color: var(--text-dark);">
                    <i class="fas fa-graduation-cap me-2" style="color: var(--pink-primary);"></i>
                    NarayaLearn
                </h5>
                <p class="text-muted small mb-0">
                    Platform belajar interaktif dengan materi, video, dan latihan soal untuk siswa Indonesia.
                </p>
            </div>

            <!-- Social Media -->
            <div class="col-auto text-center ">
                <h6 class="fw-bold mb-3" style="color: var(--text-dark);">Ikuti Kami</h6>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                    <a href="https://instagram.com/smtr25_official" target="_blank" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com/@smtr25" target="_blank" class="social-icon" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://tiktok.com/@smtr25official" target="_blank" class="social-icon" title="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://twitter.com/smtr25_official" target="_blank" class="social-icon" title="Twitter / X">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-4" style="border-color: var(--pink-light);">

        <div class="text-center">
            <small class="text-muted">
                &copy; {{ date('Y') }} NarayaLearn. All rights reserved.
            </small>
        </div>
    </div>
</footer>

<style>
    .footer-pink {
        background: #fff;
        border-top: 3px solid var(--pink-light);
        margin-top: 60px;
    }

    .social-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--pink-soft);
        color: var(--pink-primary) !important;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 18px;
    }

    .social-icon:hover {
        background: var(--pink-primary);
        color: #fff !important;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(255, 107, 157, 0.3);
    }

    /* Mobile tweaks */
    @media (max-width: 768px) {
        .footer-pink {
            text-align: center;
        }
        .social-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }
    }
</style>