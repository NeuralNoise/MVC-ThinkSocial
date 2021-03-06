<div class="w3-col m3 groups">

    <?php if (!$hasAvatar) : ?>
    <div class="avatar-drop-box">
        <span class="drop-box-advise"> Move your group photo here </span>
        <span class="drop-box-alt"> or </span>
        <label class="w3-btn w3-ripple w3-orange upload-wrapper" for="avatar-input"> Upload </label>
    </div>
        <input id="avatar-input" class="avatar-upload-file" type="file" >
    <?php else : ?>
        <img src="/avatars/<?= $groupAvatar ?>" class="group-avatar-page-image" alt="Avatar">
    <?php endif; ?>

    <a href="#" class="group-card__subs w3-btn w3-ripple w3-teal group-card__subs-main"> Manage </a>
    <section class="group-page-subs">
        <h2 class="group-page-subs-title"> Subscribers </h2>
        <div class="subscriber-container subscriber-container-empty">
            Group has no subscribers
        </div>
    </section>
</div>