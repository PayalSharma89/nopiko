<template>
  <div v-if="showPopup" class="install-popup">
    <div class="popup-content">
      <p>Install this app to your home screen for a better experience!</p>
      <button @click="installPWA">Install</button>
      <button @click="closePopup">Close</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showPopup: false,
      deferredPrompt: null,
    };
  },
  created() {
    // Listen for the 'beforeinstallprompt' event
    window.addEventListener('beforeinstallprompt', this.handleBeforeInstallPrompt);

    // Check if the user is on mobile and show the popup after 10 seconds
    if (this.isMobile()) {
      setTimeout(() => {
        this.showPopup = true;
      }, 10000); // 10 seconds
    }
  },
  destroyed() {
    // Clean up event listeners when the component is destroyed
    window.removeEventListener('beforeinstallprompt', this.handleBeforeInstallPrompt);
  },
  methods: {
    handleBeforeInstallPrompt(event) {
      // Save the event for triggering the installation
      this.deferredPrompt = event;
    },
    installPWA() {
      if (this.deferredPrompt) {
        this.deferredPrompt.prompt();
        this.deferredPrompt.userChoice.then((choiceResult) => {
          this.deferredPrompt = null;
          this.showPopup = false;
        });
      }
    },
    closePopup() {
      this.showPopup = false;
    },
    isMobile() {
      // Use matchMedia to check for mobile devices
      return window.matchMedia("(max-width: 768px)").matches;
    }
  },
};
</script>

<style scoped>
.install-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); /* This will center it both vertically and horizontally */
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 9999;
  text-align: center;
}

.popup-content button {
  margin: 5px;
  padding: 10px 15px;
  background-color: #4DBA87;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.popup-content button:hover {
  background-color: #45a074;
}

</style>
