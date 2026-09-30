/*

  PAGE LOADER
  
*/

class Loader {
    constructor(onProgress, onComplete) {
        console.log("Loading: 0%");
        this.images = Array.from(document.querySelectorAll('img'));
        this.total = this.images.length;
        this.loaded = 0;
        this.onProgress = onProgress || (() => {}); 
        this.onComplete = onComplete || (() => {});
    }

    init() {
        if (this.total === 0) {
            this.onComplete();
            return;
        }

        let completed = false;
        const completeOnce = () => {
            if (!completed) {
                completed = true;
                this.onComplete();
            }
        };

        // Safety fallback: if images take too long or stall, complete anyway
        const safetyTimeout = setTimeout(() => {
            if (this.loaded < this.total) {
                console.warn('Loader timed out waiting for images, proceeding.');
                completeOnce();
            }
        }, 2000);

        const checkDone = () => {
            if (this.loaded >= this.total) {
                clearTimeout(safetyTimeout);
                completeOnce();
            }
        };

        this.images.forEach(img => {
            const rawSrc = img.getAttribute('src');
            if (!rawSrc || rawSrc.trim() === '' || img.src === window.location.href) {
                this.loaded++;
                checkDone();
                return;
            }

            if (img.complete && img.naturalWidth > 0) {
                this.updateProgress();
                checkDone();
                return;
            }

            const tempImage = new Image();
            tempImage.onload = () => {
                const rect = img.getBoundingClientRect();
                const width = rect.width;
                const height = rect.height;

                img.width = width;
                img.height = height;

                img.style.setProperty('--w', `${width}px`);
                img.style.setProperty('--h', `${height}px`);

                this.updateProgress();
                checkDone();
            };

            tempImage.onerror = () => {
                console.warn(`Failed to load: ${img.src}`);
                this.updateProgress();
                checkDone();
            };

            tempImage.src = img.src;
        });
    }

    updateProgress() {
        this.loaded++;
        const percent = Math.min(Math.floor((this.loaded / this.total) * 100), 100);
        this.onProgress(percent);
    }
}