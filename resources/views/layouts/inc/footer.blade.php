<footer class="footer-pink py-4 mt-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start">
                <h5 class="fw-bold" style="color: var(--text-dark);">
                    <i class="fas fa-graduation-cap" style="color: var(--pink-primary);"></i>
                    {{ config('app.name', 'NarayaLearn') }}
                </h5>
                <p class="text-muted small mb-0">
                    Platform belajar interaktif dengan materi, video, dan latihan soal.
                </p>
            </div>

            <div class="col-md-4 text-center">
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="text-muted" title="Instagram">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-muted" title="YouTube">
                        <i class="fab fa-youtube fa-lg"></i>
                    </a>
                    <a href="#" class="text-muted" title="TikTok">
                        <i class="fab fa-tiktok fa-lg"></i>
                    </a>
                    <a href="#" class="text-muted" title="Twitter">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <span class="text-muted small">
                    &copy; {{ date('Y') }} NarayaLearn. 
                    Made with <i class="fas fa-heart" style="color: var(--pink-primary);"></i>
                </span>
            </div>
        </div>
    </div>
</footer>