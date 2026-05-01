<div class="w-full relative h-14 bg-surface-variant rounded-full overflow-hidden shadow-inner flex items-center justify-center select-none"
    x-data="{
        startX: 0,
        currentX: 0,
        maxSlide: 0,
        swiped: false,
        btnWidth: 56, // 14rem = 56px (approx height for a perfect circle button)
        init() {
            // Calculate max slide distance
            this.maxSlide = this.$el.offsetWidth - this.btnWidth - 8; // 8px padding
            window.addEventListener('resize', () => {
                this.maxSlide = this.$el.offsetWidth - this.btnWidth - 8;
            });
        },
        startSwipe(e) {
            if (this.swiped) return;
            this.startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
        },
        moveSwipe(e) {
            if (!this.startX || this.swiped) return;
            
            let clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
            let moveX = clientX - this.startX;
            
            // Limit movement
            if (moveX > 0 && moveX <= this.maxSlide) {
                this.currentX = moveX;
            } else if (moveX > this.maxSlide) {
                this.currentX = this.maxSlide;
            }
        },
        endSwipe() {
            if (!this.startX || this.swiped) return;
            
            // Threshold is 80% of max slide
            if (this.currentX > (this.maxSlide * 0.8)) {
                this.currentX = this.maxSlide;
                this.swiped = true;
                
                // Trigger action here (e.g., dispatch to parent component or submit form)
                this.$dispatch('task-completed');
                
                // For demo purpose, we show a success state, then redirect or show modal
                setTimeout(() => {
                    window.location.href = '{{ route('petugas.riwayat') }}';
                }, 800);
            } else {
                // Snap back
                this.currentX = 0;
            }
            this.startX = 0;
        }
    }"
    @touchstart="startSwipe"
    @touchmove="moveSwipe"
    @touchend="endSwipe"
    @mousedown="startSwipe"
    @mousemove="window.addEventListener('mousemove', moveSwipe)"
    @mouseup="window.removeEventListener('mousemove', moveSwipe); endSwipe()"
    @mouseleave="window.removeEventListener('mousemove', moveSwipe); endSwipe()"
>
    <!-- Background Text -->
    <span class="absolute font-bold text-on-surface-variant z-0 transition-opacity duration-300" :class="{ 'opacity-0': swiped || currentX > 20 }">
        Geser untuk Selesai
    </span>
    
    <!-- Success Text -->
    <span class="absolute font-black text-white z-20 transition-opacity duration-300 opacity-0" :class="{ 'opacity-100': swiped }">
        Tugas Selesai!
    </span>

    <!-- Progress Fill -->
    <div class="absolute left-0 top-0 h-full bg-primary z-10 rounded-full" :style="`width: ${currentX + btnWidth}px`" :class="{ 'transition-all duration-300': !startX || swiped }"></div>

    <!-- Draggable Button -->
    <div class="absolute left-1 w-12 h-12 bg-white rounded-full shadow-md z-20 flex items-center justify-center text-primary"
         :style="`transform: translateX(${currentX}px)`"
         :class="{ 'transition-transform duration-300': !startX || swiped }">
        
        <span x-show="!swiped" class="material-symbols-outlined font-bold">arrow_forward</span>
        <span x-show="swiped" class="material-symbols-outlined font-bold" style="display: none;">check</span>
    </div>
</div>
