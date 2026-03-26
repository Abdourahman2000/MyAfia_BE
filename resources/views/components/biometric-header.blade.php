@props(['title', 'description', 'icon'])
<div class="biometric-title">
    <div class="biometric-title-icon">
        <i class="{{ $icon }}"></i>
    </div>
    <div>
        <h2>{{ $title }}</h2>
        <p>{{ $description }}</p>
    </div>
</div>

<style>
    .biometric-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .biometric-title-icon {
        width: 48px;
        height: 48px;
        background: #eaf1ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #4a7dff;
    }

    .biometric-title h2 {
        margin: 0;
        font-weight: 700;
    }

    .biometric-title p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }
</style>
