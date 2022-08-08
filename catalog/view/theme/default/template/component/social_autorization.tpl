<div class="social-autorization">
    <button type="button" onclick="social_auth.facebook(this)" data-loading-text="<?= $text_loading; ?>" class="btn social-autorization__btn social-autorization__btn--facebook">
        <img src="catalog/view/theme/default/image/sd-facebook-icon.svg" alt="Facebook"> Facebook
    </button>

    <button type="button" onclick="social_auth.googleplus(this)" data-loading-text="<?= $text_loading; ?>" class="btn social-autorization__btn social-autorization__btn--google">
        <img src="catalog/view/theme/default/image/sd-google-icon.svg" alt="Google"> Google
    </button>

    <?php /* 
    <button type="button" onclick="social_auth.instagram(this)" data-loading-text="<?= $text_loading; ?>" class="btn social-autorization__btn social-autorization__btn--instagram">
        <img src="catalog/view/theme/default/image/sd-instagram-icon.svg" alt="Instagram"> Instagram
    </button>
     */ ?>
</div>