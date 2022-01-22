<template>
  <div class="full-overlay">
      <div class="full-overlay__inner">
          <div class="full-overlay__content"><span class="full-spinner"></span></div>
      </div>
  </div>
</template>

<style>
  .full-overlay {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: fixed;
    background: rgb(255, 250, 250);
    opacity: 0.4;
    z-index: 100000;
}

.full-overlay__inner {
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    position: absolute;
}

.full-overlay__content {
    left: 50%;
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
}

.full-spinner {
    width: 75px;
    height: 75px;
    display: inline-block;
    border-width: 2px;
    border-color: rgba(255, 255, 255, 0.05);
    border-top-color: rgb(15, 44, 209);
    animation: spin 1s infinite linear;
    border-radius: 100%;
    border-style: solid;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>