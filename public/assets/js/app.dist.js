var __defProp = Object.defineProperty;
var __defNormalProp = (obj, key, value) => key in obj ? __defProp(obj, key, { enumerable: true, configurable: true, writable: true, value }) : obj[key] = value;
var __publicField = (obj, key, value) => __defNormalProp(obj, typeof key !== "symbol" ? key + "" : key, value);
var t = "1.3.18";
function e(c, p, d) {
  return Math.max(c, Math.min(p, d));
}
var i = class {
  constructor() {
    __publicField(this, "isRunning", false);
    __publicField(this, "value", 0);
    __publicField(this, "from", 0);
    __publicField(this, "to", 0);
    __publicField(this, "currentTime", 0);
    __publicField(this, "lerp");
    __publicField(this, "duration");
    __publicField(this, "easing");
    __publicField(this, "onUpdate");
  }
  advance(c) {
    if (!this.isRunning) return;
    let p = false;
    if (this.duration && this.easing) {
      this.currentTime += c;
      let d = e(0, this.currentTime / this.duration, 1);
      p = d >= 1;
      let u = p ? 1 : this.easing(d);
      this.value = this.from + (this.to - this.from) * u;
    } else {
      var v, m, g, S, f, w, y;
      this.lerp ? (this.value = (v = this.value, m = this.to, g = 60 * this.lerp, S = c, f = v, w = m, (1 - (y = 1 - Math.exp(-g * S))) * f + y * w), Math.round(this.value) === this.to && (this.value = this.to, p = true)) : (this.value = this.to, p = true);
    }
    p && this.stop(), this.onUpdate?.(this.value, p);
  }
  stop() {
    this.isRunning = false;
  }
  fromTo(c, p, { lerp: d, duration: u, easing: v, onStart: m, onUpdate: g }) {
    this.from = this.value = c, this.to = p, this.lerp = d, this.duration = u, this.easing = v, this.currentTime = 0, this.isRunning = true, m?.(), this.onUpdate = g;
  }
}, s = class {
  constructor(c, p, { autoResize: d = true, debounce: u = 250 } = {}) {
    __publicField(this, "width", 0);
    __publicField(this, "height", 0);
    __publicField(this, "scrollHeight", 0);
    __publicField(this, "scrollWidth", 0);
    __publicField(this, "debouncedResize");
    __publicField(this, "wrapperResizeObserver");
    __publicField(this, "contentResizeObserver");
    __publicField(this, "resize", () => {
      this.onWrapperResize(), this.onContentResize();
    });
    __publicField(this, "onWrapperResize", () => {
      this.wrapper instanceof Window ? (this.width = window.innerWidth, this.height = window.innerHeight) : (this.width = this.wrapper.clientWidth, this.height = this.wrapper.clientHeight);
    });
    __publicField(this, "onContentResize", () => {
      this.wrapper instanceof Window ? (this.scrollHeight = this.content.scrollHeight, this.scrollWidth = this.content.scrollWidth) : (this.scrollHeight = this.wrapper.scrollHeight, this.scrollWidth = this.wrapper.scrollWidth);
    });
    this.wrapper = c, this.content = p, d && (this.debouncedResize = /* @__PURE__ */ (function(c2, p2) {
      let d2;
      return function(...u2) {
        clearTimeout(d2), d2 = setTimeout(() => {
          d2 = void 0, c2.apply(this, u2);
        }, p2);
      };
    })(this.resize, u), this.wrapper instanceof Window ? window.addEventListener("resize", this.debouncedResize) : (this.wrapperResizeObserver = new ResizeObserver(this.debouncedResize), this.wrapperResizeObserver.observe(this.wrapper)), this.contentResizeObserver = new ResizeObserver(this.debouncedResize), this.contentResizeObserver.observe(this.content)), this.resize();
  }
  destroy() {
    this.wrapperResizeObserver?.disconnect(), this.contentResizeObserver?.disconnect(), this.wrapper === window && this.debouncedResize && window.removeEventListener("resize", this.debouncedResize);
  }
  get limit() {
    return { x: this.scrollWidth - this.width, y: this.scrollHeight - this.height };
  }
}, o = class {
  constructor() {
    __publicField(this, "events", {});
  }
  emit(c, ...p) {
    let d = this.events[c] || [];
    for (let u = 0, v = d.length; u < v; u++) d[u]?.(...p);
  }
  on(c, p) {
    return this.events[c] ? this.events[c].push(p) : this.events[c] = [p], () => {
      this.events[c] = this.events[c]?.filter((c2) => p !== c2);
    };
  }
  off(c, p) {
    this.events[c] = this.events[c]?.filter((c2) => p !== c2);
  }
  destroy() {
    this.events = {};
  }
}, n = 100 / 6, r = { passive: false };
function l(c, p) {
  return 1 === c ? n : 2 === c ? p : 1;
}
var h = class {
  constructor(c, p = { wheelMultiplier: 1, touchMultiplier: 1 }) {
    __publicField(this, "touchStart", { x: 0, y: 0 });
    __publicField(this, "lastDelta", { x: 0, y: 0 });
    __publicField(this, "window", { width: 0, height: 0 });
    __publicField(this, "emitter", new o());
    __publicField(this, "onTouchStart", (c) => {
      let { clientX: p, clientY: d } = c.targetTouches ? c.targetTouches[0] : c;
      this.touchStart.x = p, this.touchStart.y = d, this.lastDelta = { x: 0, y: 0 }, this.emitter.emit("scroll", { deltaX: 0, deltaY: 0, event: c });
    });
    __publicField(this, "onTouchMove", (c) => {
      let { clientX: p, clientY: d } = c.targetTouches ? c.targetTouches[0] : c, u = -(p - this.touchStart.x) * this.options.touchMultiplier, v = -(d - this.touchStart.y) * this.options.touchMultiplier;
      this.touchStart.x = p, this.touchStart.y = d, this.lastDelta = { x: u, y: v }, this.emitter.emit("scroll", { deltaX: u, deltaY: v, event: c });
    });
    __publicField(this, "onTouchEnd", (c) => {
      this.emitter.emit("scroll", { deltaX: this.lastDelta.x, deltaY: this.lastDelta.y, event: c });
    });
    __publicField(this, "onWheel", (c) => {
      let { deltaX: p, deltaY: d, deltaMode: u } = c;
      p *= l(u, this.window.width), d *= l(u, this.window.height), p *= this.options.wheelMultiplier, d *= this.options.wheelMultiplier, this.emitter.emit("scroll", { deltaX: p, deltaY: d, event: c });
    });
    __publicField(this, "onWindowResize", () => {
      this.window = { width: window.innerWidth, height: window.innerHeight };
    });
    this.element = c, this.options = p, window.addEventListener("resize", this.onWindowResize), this.onWindowResize(), this.element.addEventListener("wheel", this.onWheel, r), this.element.addEventListener("touchstart", this.onTouchStart, r), this.element.addEventListener("touchmove", this.onTouchMove, r), this.element.addEventListener("touchend", this.onTouchEnd, r);
  }
  on(c, p) {
    return this.emitter.on(c, p);
  }
  destroy() {
    this.emitter.destroy(), window.removeEventListener("resize", this.onWindowResize), this.element.removeEventListener("wheel", this.onWheel, r), this.element.removeEventListener("touchstart", this.onTouchStart, r), this.element.removeEventListener("touchmove", this.onTouchMove, r), this.element.removeEventListener("touchend", this.onTouchEnd, r);
  }
}, a = (c) => Math.min(1, 1.001 - 2 ** (-10 * c)), Lenis = class {
  constructor({ wrapper: c = window, content: p = document.documentElement, eventsTarget: d = c, smoothWheel: u = true, syncTouch: v = false, syncTouchLerp: m = 0.075, touchInertiaExponent: g = 1.7, duration: S, easing: f, lerp: w = 0.1, infinite: y = false, orientation: $ = "vertical", gestureOrientation: E = "horizontal" === $ ? "both" : "vertical", touchMultiplier: _ = 1, wheelMultiplier: z = 1, autoResize: b = true, prevent: T, virtualScroll: L, overscroll: N = true, autoRaf: R = false, anchors: O = false, autoToggle: W = false, allowNestedScroll: x = false, __experimental__naiveDimensions: H = false, naiveDimensions: k = H, stopInertiaOnNavigate: X = false } = {}) {
    __publicField(this, "_isScrolling", false);
    __publicField(this, "_isStopped", false);
    __publicField(this, "_isLocked", false);
    __publicField(this, "_preventNextNativeScrollEvent", false);
    __publicField(this, "_resetVelocityTimeout", null);
    __publicField(this, "_rafId", null);
    __publicField(this, "isTouching");
    __publicField(this, "time", 0);
    __publicField(this, "userData", {});
    __publicField(this, "lastVelocity", 0);
    __publicField(this, "velocity", 0);
    __publicField(this, "direction", 0);
    __publicField(this, "options");
    __publicField(this, "targetScroll");
    __publicField(this, "animatedScroll");
    __publicField(this, "animate", new i());
    __publicField(this, "emitter", new o());
    __publicField(this, "dimensions");
    __publicField(this, "virtualScroll");
    __publicField(this, "onScrollEnd", (c) => {
      c instanceof CustomEvent || "smooth" !== this.isScrolling && false !== this.isScrolling || c.stopPropagation();
    });
    __publicField(this, "dispatchScrollendEvent", () => {
      this.options.wrapper.dispatchEvent(new CustomEvent("scrollend", { bubbles: this.options.wrapper === window, detail: { lenisScrollEnd: true } }));
    });
    __publicField(this, "onTransitionEnd", (c) => {
      c.propertyName.includes("overflow") && this.checkOverflow();
    });
    __publicField(this, "onClick", (c) => {
      let p = c.composedPath().filter((c2) => c2 instanceof HTMLAnchorElement && c2.getAttribute("href"));
      if (this.options.anchors) {
        let d = p.find((c2) => c2.getAttribute("href")?.includes("#"));
        if (d) {
          let u = d.getAttribute("href");
          if (u) {
            let v = "object" == typeof this.options.anchors && this.options.anchors ? this.options.anchors : void 0, m = `#${u.split("#")[1]}`;
            this.scrollTo(m, v);
          }
        }
      }
      this.options.stopInertiaOnNavigate && p.find((c2) => c2.host === window.location.host) && this.reset();
    });
    __publicField(this, "onPointerDown", (c) => {
      1 === c.button && this.reset();
    });
    __publicField(this, "onVirtualScroll", (c) => {
      if ("function" == typeof this.options.virtualScroll && false === this.options.virtualScroll(c)) return;
      let { deltaX: p, deltaY: d, event: u } = c;
      if (this.emitter.emit("virtual-scroll", { deltaX: p, deltaY: d, event: u }), u.ctrlKey || u.lenisStopPropagation) return;
      let v = u.type.includes("touch"), m = u.type.includes("wheel");
      this.isTouching = "touchstart" === u.type || "touchmove" === u.type;
      let g = 0 === p && 0 === d;
      if (this.options.syncTouch && v && "touchstart" === u.type && g && !this.isStopped && !this.isLocked) return void this.reset();
      let S = "vertical" === this.options.gestureOrientation && 0 === d || "horizontal" === this.options.gestureOrientation && 0 === p;
      if (g || S) return;
      let f = u.composedPath();
      f = f.slice(0, f.indexOf(this.rootElement));
      let w = this.options.prevent, y = Math.abs(p) >= Math.abs(d) ? "horizontal" : "vertical";
      if (f.find((c2) => c2 instanceof HTMLElement && ("function" == typeof w && w?.(c2) || c2.hasAttribute?.("data-lenis-prevent") || "vertical" === y && c2.hasAttribute?.("data-lenis-prevent-vertical") || "horizontal" === y && c2.hasAttribute?.("data-lenis-prevent-horizontal") || v && c2.hasAttribute?.("data-lenis-prevent-touch") || m && c2.hasAttribute?.("data-lenis-prevent-wheel") || this.options.allowNestedScroll && this.hasNestedScroll(c2, { deltaX: p, deltaY: d })))) return;
      if (this.isStopped || this.isLocked) return void (u.cancelable && u.preventDefault());
      if (!(this.options.syncTouch && v || this.options.smoothWheel && m)) return this.isScrolling = "native", this.animate.stop(), void (u.lenisStopPropagation = true);
      let $ = d;
      "both" === this.options.gestureOrientation ? $ = Math.abs(d) > Math.abs(p) ? d : p : "horizontal" === this.options.gestureOrientation && ($ = p), (!this.options.overscroll || this.options.infinite || this.options.wrapper !== window && this.limit > 0 && (this.animatedScroll > 0 && this.animatedScroll < this.limit || 0 === this.animatedScroll && d > 0 || this.animatedScroll === this.limit && d < 0)) && (u.lenisStopPropagation = true), u.cancelable && u.preventDefault();
      let E = v && this.options.syncTouch, _ = v && "touchend" === u.type;
      _ && ($ = Math.sign(this.velocity) * Math.abs(this.velocity) ** this.options.touchInertiaExponent), this.scrollTo(this.targetScroll + $, { programmatic: false, ...E ? { lerp: _ ? this.options.syncTouchLerp : 1 } : { lerp: this.options.lerp, duration: this.options.duration, easing: this.options.easing } });
    });
    __publicField(this, "onNativeScroll", () => {
      if (null !== this._resetVelocityTimeout && (clearTimeout(this._resetVelocityTimeout), this._resetVelocityTimeout = null), this._preventNextNativeScrollEvent) this._preventNextNativeScrollEvent = false;
      else if (false === this.isScrolling || "native" === this.isScrolling) {
        let c = this.animatedScroll;
        this.animatedScroll = this.targetScroll = this.actualScroll, this.lastVelocity = this.velocity, this.velocity = this.animatedScroll - c, this.direction = Math.sign(this.animatedScroll - c), this.isStopped || (this.isScrolling = "native"), this.emit(), 0 !== this.velocity && (this._resetVelocityTimeout = setTimeout(() => {
          this.lastVelocity = this.velocity, this.velocity = 0, this.isScrolling = false, this.emit();
        }, 400));
      }
    });
    __publicField(this, "raf", (c) => {
      let p = c - (this.time || c);
      this.time = c, this.animate.advance(1e-3 * p), this.options.autoRaf && (this._rafId = requestAnimationFrame(this.raf));
    });
    window.lenisVersion = t, window.lenis || (window.lenis = {}), window.lenis.version = t, "horizontal" === $ && (window.lenis.horizontal = true), c && c !== document.documentElement || (c = window), "number" == typeof S && "function" != typeof f ? f = a : "function" == typeof f && "number" != typeof S && (S = 1), this.options = { wrapper: c, content: p, eventsTarget: d, smoothWheel: u, syncTouch: v, syncTouchLerp: m, touchInertiaExponent: g, duration: S, easing: f, lerp: w, infinite: y, gestureOrientation: E, orientation: $, touchMultiplier: _, wheelMultiplier: z, autoResize: b, prevent: T, virtualScroll: L, overscroll: N, autoRaf: R, anchors: O, autoToggle: W, allowNestedScroll: x, naiveDimensions: k, stopInertiaOnNavigate: X }, this.dimensions = new s(c, p, { autoResize: b }), this.updateClassName(), this.targetScroll = this.animatedScroll = this.actualScroll, this.options.wrapper.addEventListener("scroll", this.onNativeScroll), this.options.wrapper.addEventListener("scrollend", this.onScrollEnd, { capture: true }), (this.options.anchors || this.options.stopInertiaOnNavigate) && this.options.wrapper.addEventListener("click", this.onClick), this.options.wrapper.addEventListener("pointerdown", this.onPointerDown), this.virtualScroll = new h(d, { touchMultiplier: _, wheelMultiplier: z }), this.virtualScroll.on("scroll", this.onVirtualScroll), this.options.autoToggle && (this.checkOverflow(), this.rootElement.addEventListener("transitionend", this.onTransitionEnd)), this.options.autoRaf && (this._rafId = requestAnimationFrame(this.raf));
  }
  destroy() {
    this.emitter.destroy(), this.options.wrapper.removeEventListener("scroll", this.onNativeScroll), this.options.wrapper.removeEventListener("scrollend", this.onScrollEnd, { capture: true }), this.options.wrapper.removeEventListener("pointerdown", this.onPointerDown), (this.options.anchors || this.options.stopInertiaOnNavigate) && this.options.wrapper.removeEventListener("click", this.onClick), this.virtualScroll.destroy(), this.dimensions.destroy(), this.cleanUpClassName(), this._rafId && cancelAnimationFrame(this._rafId);
  }
  on(c, p) {
    return this.emitter.on(c, p);
  }
  off(c, p) {
    return this.emitter.off(c, p);
  }
  get overflow() {
    let c = this.isHorizontal ? "overflow-x" : "overflow-y";
    return getComputedStyle(this.rootElement)[c];
  }
  checkOverflow() {
    ["hidden", "clip"].includes(this.overflow) ? this.internalStop() : this.internalStart();
  }
  setScroll(c) {
    this.isHorizontal ? this.options.wrapper.scrollTo({ left: c, behavior: "instant" }) : this.options.wrapper.scrollTo({ top: c, behavior: "instant" });
  }
  resize() {
    this.dimensions.resize(), this.animatedScroll = this.targetScroll = this.actualScroll, this.emit();
  }
  emit() {
    this.emitter.emit("scroll", this);
  }
  reset() {
    this.isLocked = false, this.isScrolling = false, this.animatedScroll = this.targetScroll = this.actualScroll, this.lastVelocity = this.velocity = 0, this.animate.stop();
  }
  start() {
    this.isStopped && (this.options.autoToggle ? this.rootElement.style.removeProperty("overflow") : this.internalStart());
  }
  internalStart() {
    this.isStopped && (this.reset(), this.isStopped = false, this.emit());
  }
  stop() {
    this.isStopped || (this.options.autoToggle ? this.rootElement.style.setProperty("overflow", "clip") : this.internalStop());
  }
  internalStop() {
    this.isStopped || (this.reset(), this.isStopped = true, this.emit());
  }
  scrollTo(c, { offset: p = 0, immediate: d = false, lock: u = false, programmatic: v = true, lerp: m = v ? this.options.lerp : void 0, duration: g = v ? this.options.duration : void 0, easing: S = v ? this.options.easing : void 0, onStart: f, onComplete: w, force: y = false, userData: $ } = {}) {
    if ((this.isStopped || this.isLocked) && !y) return;
    let E = c, _ = p;
    if ("string" == typeof E && ["top", "left", "start", "#"].includes(E)) E = 0;
    else if ("string" == typeof E && ["bottom", "right", "end"].includes(E)) E = this.limit;
    else {
      let z = null;
      if ("string" == typeof E ? (z = document.querySelector(E)) || ("#top" === E ? E = 0 : console.warn("Lenis: Target not found", E)) : E instanceof HTMLElement && E?.nodeType && (z = E), z) {
        if (this.options.wrapper !== window) {
          let b = this.rootElement.getBoundingClientRect();
          _ -= this.isHorizontal ? b.left : b.top;
        }
        let T = z.getBoundingClientRect();
        E = (this.isHorizontal ? T.left : T.top) + this.animatedScroll;
      }
    }
    if ("number" == typeof E) {
      if (E += _, E = Math.round(E), this.options.infinite) {
        if (v) {
          this.targetScroll = this.animatedScroll = this.scroll;
          let L = E - this.animatedScroll;
          L > this.limit / 2 ? E -= this.limit : L < -this.limit / 2 && (E += this.limit);
        }
      } else E = e(0, E, this.limit);
      if (E === this.targetScroll) return f?.(this), void w?.(this);
      if (this.userData = $ ?? {}, d) return this.animatedScroll = this.targetScroll = E, this.setScroll(this.scroll), this.reset(), this.preventNextNativeScrollEvent(), this.emit(), w?.(this), this.userData = {}, void requestAnimationFrame(() => {
        this.dispatchScrollendEvent();
      });
      v || (this.targetScroll = E), "number" == typeof g && "function" != typeof S ? S = a : "function" == typeof S && "number" != typeof g && (g = 1), this.animate.fromTo(this.animatedScroll, E, { duration: g, easing: S, lerp: m, onStart: () => {
        u && (this.isLocked = true), this.isScrolling = "smooth", f?.(this);
      }, onUpdate: (c2, p2) => {
        this.isScrolling = "smooth", this.lastVelocity = this.velocity, this.velocity = c2 - this.animatedScroll, this.direction = Math.sign(this.velocity), this.animatedScroll = c2, this.setScroll(this.scroll), v && (this.targetScroll = c2), p2 || this.emit(), p2 && (this.reset(), this.emit(), w?.(this), this.userData = {}, requestAnimationFrame(() => {
          this.dispatchScrollendEvent();
        }), this.preventNextNativeScrollEvent());
      } });
    }
  }
  preventNextNativeScrollEvent() {
    this._preventNextNativeScrollEvent = true, requestAnimationFrame(() => {
      this._preventNextNativeScrollEvent = false;
    });
  }
  hasNestedScroll(c, { deltaX: p, deltaY: d }) {
    let u = Date.now();
    c._lenis || (c._lenis = {});
    let v = c._lenis, m, g, S, f, w, y, $, E, _, z;
    if (u - (v.time ?? 0) > 2e3) {
      v.time = Date.now();
      let b = window.getComputedStyle(c);
      if (v.computedStyle = b, m = ["auto", "overlay", "scroll"].includes(b.overflowX), g = ["auto", "overlay", "scroll"].includes(b.overflowY), w = ["auto"].includes(b.overscrollBehaviorX), y = ["auto"].includes(b.overscrollBehaviorY), v.hasOverflowX = m, v.hasOverflowY = g, !m && !g) return false;
      $ = c.scrollWidth, E = c.scrollHeight, _ = c.clientWidth, z = c.clientHeight, S = $ > _, f = E > z, v.isScrollableX = S, v.isScrollableY = f, v.scrollWidth = $, v.scrollHeight = E, v.clientWidth = _, v.clientHeight = z, v.hasOverscrollBehaviorX = w, v.hasOverscrollBehaviorY = y;
    } else S = v.isScrollableX, f = v.isScrollableY, m = v.hasOverflowX, g = v.hasOverflowY, $ = v.scrollWidth, E = v.scrollHeight, _ = v.clientWidth, z = v.clientHeight, w = v.hasOverscrollBehaviorX, y = v.hasOverscrollBehaviorY;
    if (!(m && S || g && f)) return false;
    let T = Math.abs(p) >= Math.abs(d) ? "horizontal" : "vertical", L, N, R, O, W, x;
    if ("horizontal" === T) L = Math.round(c.scrollLeft), N = $ - _, R = p, O = m, W = S, x = w;
    else {
      if ("vertical" !== T) return false;
      L = Math.round(c.scrollTop), N = E - z, R = d, O = g, W = f, x = y;
    }
    return !x && (L >= N || L <= 0) || (R > 0 ? L < N : L > 0) && O && W;
  }
  get rootElement() {
    return this.options.wrapper === window ? document.documentElement : this.options.wrapper;
  }
  get limit() {
    return this.options.naiveDimensions ? this.isHorizontal ? this.rootElement.scrollWidth - this.rootElement.clientWidth : this.rootElement.scrollHeight - this.rootElement.clientHeight : this.dimensions.limit[this.isHorizontal ? "x" : "y"];
  }
  get isHorizontal() {
    return "horizontal" === this.options.orientation;
  }
  get actualScroll() {
    let c = this.options.wrapper;
    return this.isHorizontal ? c.scrollX ?? c.scrollLeft : c.scrollY ?? c.scrollTop;
  }
  get scroll() {
    var c, p;
    return this.options.infinite ? ((c = this.animatedScroll) % (p = this.limit) + p) % p : this.animatedScroll;
  }
  get progress() {
    return 0 === this.limit ? 1 : this.scroll / this.limit;
  }
  get isScrolling() {
    return this._isScrolling;
  }
  set isScrolling(c) {
    this._isScrolling !== c && (this._isScrolling = c, this.updateClassName());
  }
  get isStopped() {
    return this._isStopped;
  }
  set isStopped(c) {
    this._isStopped !== c && (this._isStopped = c, this.updateClassName());
  }
  get isLocked() {
    return this._isLocked;
  }
  set isLocked(c) {
    this._isLocked !== c && (this._isLocked = c, this.updateClassName());
  }
  get isSmooth() {
    return "smooth" === this.isScrolling;
  }
  get className() {
    let c = "lenis";
    return this.options.autoToggle && (c += " lenis-autoToggle"), this.isStopped && (c += " lenis-stopped"), this.isLocked && (c += " lenis-locked"), this.isScrolling && (c += " lenis-scrolling"), "smooth" === this.isScrolling && (c += " lenis-smooth"), c;
  }
  updateClassName() {
    this.cleanUpClassName(), this.rootElement.className = `${this.rootElement.className} ${this.className}`.trim();
  }
  cleanUpClassName() {
    this.rootElement.className = this.rootElement.className.replace(/lenis(-\w+)?/g, "").trim();
  }
};
globalThis.Lenis = Lenis, globalThis.Lenis.prototype = Lenis.prototype;
!(function(n2, t2) {
  "object" == typeof exports && "undefined" != typeof module ? module.exports = t2() : "function" == typeof define && define.amd ? define(t2) : n2.Splitting = t2();
})(this, function() {
  "use strict";
  var o2 = document, l2 = o2.createTextNode.bind(o2);
  function d(n3, t3, e3) {
    n3.style.setProperty(t3, e3);
  }
  function f(n3, t3) {
    return n3.appendChild(t3);
  }
  function p(n3, t3, e3, r3) {
    var i3 = o2.createElement("span");
    return t3 && (i3.className = t3), e3 && (!r3 && i3.setAttribute("data-" + t3, e3), i3.textContent = e3), n3 && f(n3, i3) || i3;
  }
  function h2(n3, t3) {
    return n3.getAttribute("data-" + t3);
  }
  function m(n3, t3) {
    return n3 && 0 != n3.length ? n3.nodeName ? [n3] : [].slice.call(n3[0].nodeName ? n3 : (t3 || o2).querySelectorAll(n3)) : [];
  }
  function u(n3) {
    for (var t3 = []; n3--; ) t3[n3] = [];
    return t3;
  }
  function v(n3, t3) {
    n3 && n3.some(t3);
  }
  function c(t3) {
    return function(n3) {
      return t3[n3];
    };
  }
  var a2 = {};
  function n2(n3, t3, e3, r3) {
    return { by: n3, depends: t3, key: e3, split: r3 };
  }
  function r2(n3) {
    return (function t3(e3, n4, r3) {
      var i3 = r3.indexOf(e3);
      if (-1 == i3) {
        r3.unshift(e3);
        var o3 = a2[e3];
        if (!o3) throw new Error("plugin not loaded: " + e3);
        v(o3.depends, function(n5) {
          t3(n5, e3, r3);
        });
      } else {
        var u2 = r3.indexOf(n4);
        r3.splice(i3, 1), r3.splice(u2, 0, e3);
      }
      return r3;
    })(n3, 0, []).map(c(a2));
  }
  function t2(n3) {
    a2[n3.by] = n3;
  }
  function g(n3, r3, i3, o3, u2) {
    n3.normalize();
    var c2 = [], a3 = document.createDocumentFragment();
    o3 && c2.push(n3.previousSibling);
    var s3 = [];
    return m(n3.childNodes).some(function(n4) {
      if (!n4.tagName || n4.hasChildNodes()) {
        if (n4.childNodes && n4.childNodes.length) return s3.push(n4), void c2.push.apply(c2, g(n4, r3, i3, o3, u2));
        var t3 = n4.wholeText || "", e3 = t3.trim();
        e3.length && (" " === t3[0] && s3.push(l2(" ")), v(e3.split(i3), function(n5, t4) {
          t4 && u2 && s3.push(p(a3, "whitespace", " ", u2));
          var e4 = p(a3, r3, n5);
          c2.push(e4), s3.push(e4);
        }), " " === t3[t3.length - 1] && s3.push(l2(" ")));
      } else s3.push(n4);
    }), v(s3, function(n4) {
      f(a3, n4);
    }), n3.innerHTML = "", f(n3, a3), c2;
  }
  var s2 = 0;
  var i2 = "words", e2 = n2(i2, s2, "word", function(n3) {
    return g(n3, "word", /\s+/, 0, 1);
  }), y = "chars", w = n2(y, [i2], "char", function(n3, e3, t3) {
    var r3 = [];
    return v(t3[i2], function(n4, t4) {
      r3.push.apply(r3, g(n4, "char", "", e3.whitespace && t4));
    }), r3;
  });
  function b(e3) {
    var f2 = (e3 = e3 || {}).key;
    return m(e3.target || "[data-splitting]").map(function(a3) {
      var s3 = a3["\u{1F34C}"];
      if (!e3.force && s3) return s3;
      s3 = a3["\u{1F34C}"] = { el: a3 };
      var n3 = e3.by || h2(a3, "splitting");
      n3 && "true" != n3 || (n3 = y);
      var t3 = r2(n3), l3 = (function(n4, t4) {
        for (var e4 in t4) n4[e4] = t4[e4];
        return n4;
      })({}, e3);
      return v(t3, function(n4) {
        if (n4.split) {
          var t4 = n4.by, e4 = (f2 ? "-" + f2 : "") + n4.key, r3 = n4.split(a3, l3, s3);
          e4 && (i3 = a3, c2 = (u2 = "--" + e4) + "-index", v(o3 = r3, function(n5, t5) {
            Array.isArray(n5) ? v(n5, function(n6) {
              d(n6, c2, t5);
            }) : d(n5, c2, t5);
          }), d(i3, u2 + "-total", o3.length)), s3[t4] = r3, a3.classList.add(t4);
        }
        var i3, o3, u2, c2;
      }), a3.classList.add("splitting"), s3;
    });
  }
  function N(n3, t3, e3) {
    var r3 = m(t3.matching || n3.children, n3), i3 = {};
    return v(r3, function(n4) {
      var t4 = Math.round(n4[e3]);
      (i3[t4] || (i3[t4] = [])).push(n4);
    }), Object.keys(i3).map(Number).sort(x).map(c(i3));
  }
  function x(n3, t3) {
    return n3 - t3;
  }
  b.html = function(n3) {
    var t3 = (n3 = n3 || {}).target = p();
    return t3.innerHTML = n3.content, b(n3), t3.outerHTML;
  }, b.add = t2;
  var T = n2("lines", [i2], "line", function(n3, t3, e3) {
    return N(n3, { matching: e3[i2] }, "offsetTop");
  }), L = n2("items", s2, "item", function(n3, t3) {
    return m(t3.matching || n3.children, n3);
  }), k = n2("rows", s2, "row", function(n3, t3) {
    return N(n3, t3, "offsetTop");
  }), A = n2("cols", s2, "col", function(n3, t3) {
    return N(n3, t3, "offsetLeft");
  }), C = n2("grid", ["rows", "cols"]), M = "layout", S = n2(M, s2, s2, function(n3, t3) {
    var e3 = t3.rows = +(t3.rows || h2(n3, "rows") || 1), r3 = t3.columns = +(t3.columns || h2(n3, "columns") || 1);
    if (t3.image = t3.image || h2(n3, "image") || n3.currentSrc || n3.src, t3.image) {
      var i3 = m("img", n3)[0];
      t3.image = i3 && (i3.currentSrc || i3.src);
    }
    t3.image && d(n3, "background-image", "url(" + t3.image + ")");
    for (var o3 = e3 * r3, u2 = [], c2 = p(s2, "cell-grid"); o3--; ) {
      var a3 = p(c2, "cell");
      p(a3, "cell-inner"), u2.push(a3);
    }
    return f(n3, c2), u2;
  }), H = n2("cellRows", [M], "row", function(n3, t3, e3) {
    var r3 = t3.rows, i3 = u(r3);
    return v(e3[M], function(n4, t4, e4) {
      i3[Math.floor(t4 / (e4.length / r3))].push(n4);
    }), i3;
  }), O = n2("cellColumns", [M], "col", function(n3, t3, e3) {
    var r3 = t3.columns, i3 = u(r3);
    return v(e3[M], function(n4, t4) {
      i3[t4 % r3].push(n4);
    }), i3;
  }), j = n2("cells", ["cellRows", "cellColumns"], "cell", function(n3, t3, e3) {
    return e3[M];
  });
  return t2(e2), t2(w), t2(T), t2(L), t2(k), t2(A), t2(C), t2(S), t2(H), t2(O), t2(j), b;
});
/*!
 * GSAP 3.4.2
 * https://greensock.com
 * 
 * @license Copyright 2020, GreenSock. All rights reserved.
 * Subject to the terms at https://greensock.com/standard-license or for Club GreenSock members, the agreement issued with that membership.
 * @author: Jack Doyle, jack@greensock.com
 */
!(function(t2, e2) {
  "object" == typeof exports && "undefined" != typeof module ? e2(exports) : "function" == typeof define && define.amd ? define(["exports"], e2) : e2((t2 = t2 || self).window = t2.window || {});
})(this, function(e2) {
  "use strict";
  function _inheritsLoose(t3, e3) {
    t3.prototype = Object.create(e3.prototype), (t3.prototype.constructor = t3).__proto__ = e3;
  }
  function _assertThisInitialized(t3) {
    if (void 0 === t3) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return t3;
  }
  function n2(t3) {
    return "string" == typeof t3;
  }
  function o2(t3) {
    return "function" == typeof t3;
  }
  function p(t3) {
    return "number" == typeof t3;
  }
  function q(t3) {
    return void 0 === t3;
  }
  function r2(t3) {
    return "object" == typeof t3;
  }
  function s2(t3) {
    return false !== t3;
  }
  function t2() {
    return "undefined" != typeof window;
  }
  function u(t3) {
    return o2(t3) || n2(t3);
  }
  function K(t3) {
    return (l2 = ct(t3, at)) && ie;
  }
  function L(t3, e3) {
    return console.warn("Invalid property", t3, "set to", e3, "Missing plugin? gsap.registerPlugin()");
  }
  function M(t3, e3) {
    return !e3 && console.warn(t3);
  }
  function N(t3, e3) {
    return t3 && (at[t3] = e3) && l2 && (l2[t3] = e3) || at;
  }
  function O() {
    return 0;
  }
  function Y(t3) {
    var e3, i3, n3 = t3[0];
    if (r2(n3) || o2(n3) || (t3 = [t3]), !(e3 = (n3._gsap || {}).harness)) {
      for (i3 = dt.length; i3-- && !dt[i3].targetTest(n3); ) ;
      e3 = dt[i3];
    }
    for (i3 = t3.length; i3--; ) t3[i3] && (t3[i3]._gsap || (t3[i3]._gsap = new Et(t3[i3], e3))) || t3.splice(i3, 1);
    return t3;
  }
  function Z(t3) {
    return t3._gsap || Y(yt(t3))[0]._gsap;
  }
  function $(t3, e3) {
    var r3 = t3[e3];
    return o2(r3) ? t3[e3]() : q(r3) && t3.getAttribute(e3) || r3;
  }
  function _(t3, e3) {
    return (t3 = t3.split(",")).forEach(e3) || t3;
  }
  function aa(t3) {
    return Math.round(1e5 * t3) / 1e5 || 0;
  }
  function ba(t3, e3) {
    for (var r3 = e3.length, i3 = 0; t3.indexOf(e3[i3]) < 0 && ++i3 < r3; ) ;
    return i3 < r3;
  }
  function ca(t3, e3, r3) {
    var i3, n3 = p(t3[1]), a3 = (n3 ? 2 : 1) + (e3 < 2 ? 0 : 1), o3 = t3[a3];
    if (n3 && (o3.duration = t3[1]), o3.parent = r3, e3) {
      for (i3 = o3; r3 && !("immediateRender" in i3); ) i3 = r3.vars.defaults || {}, r3 = s2(r3.vars.inherit) && r3.parent;
      o3.immediateRender = s2(i3.immediateRender), e3 < 2 ? o3.runBackwards = 1 : o3.startAt = t3[a3 - 1];
    }
    return o3;
  }
  function da() {
    var t3, e3, r3 = ot.length, i3 = ot.slice(0);
    for (ut = {}, t3 = ot.length = 0; t3 < r3; t3++) (e3 = i3[t3]) && e3._lazy && (e3.render(e3._lazy[0], e3._lazy[1], true)._lazy = 0);
  }
  function ea(t3, e3, r3, i3) {
    ot.length && da(), t3.render(e3, r3, i3), ot.length && da();
  }
  function fa(t3) {
    var e3 = parseFloat(t3);
    return (e3 || 0 === e3) && (t3 + "").match(nt).length < 2 ? e3 : t3;
  }
  function ga(t3) {
    return t3;
  }
  function ha(t3, e3) {
    for (var r3 in e3) r3 in t3 || (t3[r3] = e3[r3]);
    return t3;
  }
  function ia(t3, e3) {
    for (var r3 in e3) r3 in t3 || "duration" === r3 || "ease" === r3 || (t3[r3] = e3[r3]);
  }
  function ka(t3, e3) {
    for (var i3 in e3) t3[i3] = r2(e3[i3]) ? ka(t3[i3] || (t3[i3] = {}), e3[i3]) : e3[i3];
    return t3;
  }
  function la(t3, e3) {
    var r3, i3 = {};
    for (r3 in t3) r3 in e3 || (i3[r3] = t3[r3]);
    return i3;
  }
  function ma(t3) {
    var e3 = t3.parent || I, r3 = t3.keyframes ? ia : ha;
    if (s2(t3.inherit)) for (; e3; ) r3(t3, e3.vars.defaults), e3 = e3.parent || e3._dp;
    return t3;
  }
  function pa(t3, e3, r3, i3) {
    void 0 === r3 && (r3 = "_first"), void 0 === i3 && (i3 = "_last");
    var n3 = e3._prev, a3 = e3._next;
    n3 ? n3._next = a3 : t3[r3] === e3 && (t3[r3] = a3), a3 ? a3._prev = n3 : t3[i3] === e3 && (t3[i3] = n3), e3._next = e3._prev = e3.parent = null;
  }
  function qa(t3, e3) {
    !t3.parent || e3 && !t3.parent.autoRemoveChildren || t3.parent.remove(t3), t3._act = 0;
  }
  function ra(t3) {
    for (var e3 = t3; e3; ) e3._dirty = 1, e3 = e3.parent;
    return t3;
  }
  function ua(t3) {
    return t3._repeat ? _t(t3._tTime, t3 = t3.duration() + t3._rDelay) * t3 : 0;
  }
  function wa(t3, e3) {
    return (t3 - e3._start) * e3._ts + (0 <= e3._ts ? 0 : e3._dirty ? e3.totalDuration() : e3._tDur);
  }
  function xa(t3) {
    return t3._end = aa(t3._start + (t3._tDur / Math.abs(t3._ts || t3._rts || B) || 0));
  }
  function ya(t3, e3) {
    var r3 = t3._dp;
    return r3 && r3.smoothChildTiming && t3._ts && (t3._start = aa(t3._dp._time - (0 < t3._ts ? e3 / t3._ts : ((t3._dirty ? t3.totalDuration() : t3._tDur) - e3) / -t3._ts)), xa(t3), r3._dirty || ra(r3)), t3;
  }
  function za(t3, e3) {
    var r3;
    if ((e3._time || e3._initted && !e3._dur) && (r3 = wa(t3.rawTime(), e3), (!e3._dur || gt(0, e3.totalDuration(), r3) - e3._tTime > B) && e3.render(r3, true)), ra(t3)._dp && t3._initted && t3._time >= t3._dur && t3._ts) {
      if (t3._dur < t3.duration()) for (r3 = t3; r3._dp; ) 0 <= r3.rawTime() && r3.totalTime(r3._tTime), r3 = r3._dp;
      t3._zTime = -B;
    }
  }
  function Aa(t3, e3, r3, i3) {
    return e3.parent && qa(e3), e3._start = aa(r3 + e3._delay), e3._end = aa(e3._start + (e3.totalDuration() / Math.abs(e3.timeScale()) || 0)), (function _addLinkedListItem(t4, e4, r4, i4, n3) {
      void 0 === r4 && (r4 = "_first"), void 0 === i4 && (i4 = "_last");
      var a3, s3 = t4[i4];
      if (n3) for (a3 = e4[n3]; s3 && s3[n3] > a3; ) s3 = s3._prev;
      s3 ? (e4._next = s3._next, s3._next = e4) : (e4._next = t4[r4], t4[r4] = e4), e4._next ? e4._next._prev = e4 : t4[i4] = e4, e4._prev = s3, e4.parent = e4._dp = t4;
    })(t3, e3, "_first", "_last", t3._sort ? "_start" : 0), t3._recent = e3, i3 || za(t3, e3), t3;
  }
  function Ba(t3, e3) {
    return (at.ScrollTrigger || L("scrollTrigger", e3)) && at.ScrollTrigger.create(e3, t3);
  }
  function Ca(t3, e3, r3, i3) {
    return qt(t3, e3), t3._initted ? !r3 && t3._pt && (t3._dur && false !== t3.vars.lazy || !t3._dur && t3.vars.lazy) && d !== Mt.frame ? (ot.push(t3), t3._lazy = [e3, i3], 1) : void 0 : 1;
  }
  function Fa(t3, e3, r3) {
    var i3 = t3._repeat, n3 = aa(e3) || 0;
    return t3._dur = n3, t3._tDur = i3 ? i3 < 0 ? 1e10 : aa(n3 * (i3 + 1) + t3._rDelay * i3) : n3, t3._time > n3 && (t3._time = n3, t3._tTime = Math.min(t3._tTime, t3._tDur)), r3 || ra(t3.parent), t3.parent && xa(t3), t3;
  }
  function Ga(t3) {
    return t3 instanceof Rt ? ra(t3) : Fa(t3, t3._dur);
  }
  function Ia(t3, e3) {
    var r3, i3, a3 = t3.labels, s3 = t3._recent || mt, o3 = t3.duration() >= z ? s3.endTime(false) : t3._dur;
    return n2(e3) && (isNaN(e3) || e3 in a3) ? "<" === (r3 = e3.charAt(0)) || ">" === r3 ? ("<" === r3 ? s3._start : s3.endTime(0 <= s3._repeat)) + (parseFloat(e3.substr(1)) || 0) : (r3 = e3.indexOf("=")) < 0 ? (e3 in a3 || (a3[e3] = o3), a3[e3]) : (i3 = +(e3.charAt(r3 - 1) + e3.substr(r3 + 1)), 1 < r3 ? Ia(t3, e3.substr(0, r3 - 1)) + i3 : o3 + i3) : null == e3 ? o3 : +e3;
  }
  function Ja(t3, e3) {
    return t3 || 0 === t3 ? e3(t3) : e3;
  }
  function La(t3) {
    return (t3 + "").substr((parseFloat(t3) + "").length);
  }
  function Oa(t3, e3) {
    return t3 && r2(t3) && "length" in t3 && (!e3 && !t3.length || t3.length - 1 in t3 && r2(t3[0])) && !t3.nodeType && t3 !== i2;
  }
  function Ra(t3) {
    return t3.sort(function() {
      return 0.5 - Math.random();
    });
  }
  function Sa(t3) {
    if (o2(t3)) return t3;
    var c2 = r2(t3) ? t3 : { each: t3 }, _2 = Ft(c2.ease), m2 = c2.from || 0, g2 = parseFloat(c2.base) || 0, v2 = {}, e3 = 0 < m2 && m2 < 1, y2 = isNaN(m2) || e3, T2 = c2.axis, b2 = m2, w2 = m2;
    return n2(m2) ? b2 = w2 = { center: 0.5, edges: 0.5, end: 1 }[m2] || 0 : !e3 && y2 && (b2 = m2[0], w2 = m2[1]), function(t4, e4, r3) {
      var i3, n3, a3, s3, o3, u2, h3, l3, f2, d2 = (r3 || c2).length, p2 = v2[d2];
      if (!p2) {
        if (!(f2 = "auto" === c2.grid ? 0 : (c2.grid || [1, z])[1])) {
          for (h3 = -z; h3 < (h3 = r3[f2++].getBoundingClientRect().left) && f2 < d2; ) ;
          f2--;
        }
        for (p2 = v2[d2] = [], i3 = y2 ? Math.min(f2, d2) * b2 - 0.5 : m2 % f2, n3 = y2 ? d2 * w2 / f2 - 0.5 : m2 / f2 | 0, l3 = z, u2 = h3 = 0; u2 < d2; u2++) a3 = u2 % f2 - i3, s3 = n3 - (u2 / f2 | 0), p2[u2] = o3 = T2 ? Math.abs("y" === T2 ? s3 : a3) : j(a3 * a3 + s3 * s3), h3 < o3 && (h3 = o3), o3 < l3 && (l3 = o3);
        "random" === m2 && Ra(p2), p2.max = h3 - l3, p2.min = l3, p2.v = d2 = (parseFloat(c2.amount) || parseFloat(c2.each) * (d2 < f2 ? d2 - 1 : T2 ? "y" === T2 ? d2 / f2 : f2 : Math.max(f2, d2 / f2)) || 0) * ("edges" === m2 ? -1 : 1), p2.b = d2 < 0 ? g2 - d2 : g2, p2.u = La(c2.amount || c2.each) || 0, _2 = _2 && d2 < 0 ? Dt(_2) : _2;
      }
      return d2 = (p2[t4] - p2.min) / p2.max || 0, aa(p2.b + (_2 ? _2(d2) : d2) * p2.v) + p2.u;
    };
  }
  function Ta(e3) {
    var r3 = e3 < 1 ? Math.pow(10, (e3 + "").length - 2) : 1;
    return function(t3) {
      return Math.floor(Math.round(parseFloat(t3) / e3) * e3 * r3) / r3 + (p(t3) ? 0 : La(t3));
    };
  }
  function Ua(u2, t3) {
    var h3, l3, e3 = J(u2);
    return !e3 && r2(u2) && (h3 = e3 = u2.radius || z, u2.values ? (u2 = yt(u2.values), (l3 = !p(u2[0])) && (h3 *= h3)) : u2 = Ta(u2.increment)), Ja(t3, e3 ? o2(u2) ? function(t4) {
      return l3 = u2(t4), Math.abs(l3 - t4) <= h3 ? l3 : t4;
    } : function(t4) {
      for (var e4, r3, i3 = parseFloat(l3 ? t4.x : t4), n3 = parseFloat(l3 ? t4.y : 0), a3 = z, s3 = 0, o3 = u2.length; o3--; ) (e4 = l3 ? (e4 = u2[o3].x - i3) * e4 + (r3 = u2[o3].y - n3) * r3 : Math.abs(u2[o3] - i3)) < a3 && (a3 = e4, s3 = o3);
      return s3 = !h3 || a3 <= h3 ? u2[s3] : t4, l3 || s3 === t4 || p(t4) ? s3 : s3 + La(t4);
    } : Ta(u2));
  }
  function Va(t3, e3, r3, i3) {
    return Ja(J(t3) ? !e3 : true === r3 ? !!(r3 = 0) : !i3, function() {
      return J(t3) ? t3[~~(Math.random() * t3.length)] : (r3 = r3 || 1e-5) && (i3 = r3 < 1 ? Math.pow(10, (r3 + "").length - 2) : 1) && Math.floor(Math.round((t3 + Math.random() * (e3 - t3)) / r3) * r3 * i3) / i3;
    });
  }
  function Za(e3, r3, t3) {
    return Ja(t3, function(t4) {
      return e3[~~r3(t4)];
    });
  }
  function ab(t3) {
    for (var e3, r3, i3, n3, a3 = 0, s3 = ""; ~(e3 = t3.indexOf("random(", a3)); ) i3 = t3.indexOf(")", e3), n3 = "[" === t3.charAt(e3 + 7), r3 = t3.substr(e3 + 7, i3 - e3 - 7).match(n3 ? nt : W), s3 += t3.substr(a3, e3 - a3) + Va(n3 ? r3 : +r3[0], +r3[1], +r3[2] || 1e-5), a3 = i3 + 1;
    return s3 + t3.substr(a3, t3.length - a3);
  }
  function db(t3, e3, r3) {
    var i3, n3, a3, s3 = t3.labels, o3 = z;
    for (i3 in s3) (n3 = s3[i3] - e3) < 0 == !!r3 && n3 && o3 > (n3 = Math.abs(n3)) && (a3 = i3, o3 = n3);
    return a3;
  }
  function fb(t3) {
    return qa(t3), t3.progress() < 1 && bt(t3, "onInterrupt"), t3;
  }
  function kb(t3, e3, r3) {
    return (6 * (t3 = t3 < 0 ? t3 + 1 : 1 < t3 ? t3 - 1 : t3) < 1 ? e3 + (r3 - e3) * t3 * 6 : t3 < 0.5 ? r3 : 3 * t3 < 2 ? e3 + (r3 - e3) * (2 / 3 - t3) * 6 : e3) * wt + 0.5 | 0;
  }
  function lb(t3, e3, r3) {
    var i3, n3, a3, s3, o3, u2, h3, l3, f2, d2, c2 = t3 ? p(t3) ? [t3 >> 16, t3 >> 8 & wt, t3 & wt] : 0 : xt.black;
    if (!c2) {
      if ("," === t3.substr(-1) && (t3 = t3.substr(0, t3.length - 1)), xt[t3]) c2 = xt[t3];
      else if ("#" === t3.charAt(0)) 4 === t3.length && (t3 = "#" + (i3 = t3.charAt(1)) + i3 + (n3 = t3.charAt(2)) + n3 + (a3 = t3.charAt(3)) + a3), c2 = [(t3 = parseInt(t3.substr(1), 16)) >> 16, t3 >> 8 & wt, t3 & wt];
      else if ("hsl" === t3.substr(0, 3)) if (c2 = d2 = t3.match(W), e3) {
        if (~t3.indexOf("=")) return c2 = t3.match(H), r3 && c2.length < 4 && (c2[3] = 1), c2;
      } else s3 = +c2[0] % 360 / 360, o3 = c2[1] / 100, i3 = 2 * (u2 = c2[2] / 100) - (n3 = u2 <= 0.5 ? u2 * (o3 + 1) : u2 + o3 - u2 * o3), 3 < c2.length && (c2[3] *= 1), c2[0] = kb(s3 + 1 / 3, i3, n3), c2[1] = kb(s3, i3, n3), c2[2] = kb(s3 - 1 / 3, i3, n3);
      else c2 = t3.match(W) || xt.transparent;
      c2 = c2.map(Number);
    }
    return e3 && !d2 && (i3 = c2[0] / wt, n3 = c2[1] / wt, a3 = c2[2] / wt, u2 = ((h3 = Math.max(i3, n3, a3)) + (l3 = Math.min(i3, n3, a3))) / 2, h3 === l3 ? s3 = o3 = 0 : (f2 = h3 - l3, o3 = 0.5 < u2 ? f2 / (2 - h3 - l3) : f2 / (h3 + l3), s3 = h3 === i3 ? (n3 - a3) / f2 + (n3 < a3 ? 6 : 0) : h3 === n3 ? (a3 - i3) / f2 + 2 : (i3 - n3) / f2 + 4, s3 *= 60), c2[0] = ~~(s3 + 0.5), c2[1] = ~~(100 * o3 + 0.5), c2[2] = ~~(100 * u2 + 0.5)), r3 && c2.length < 4 && (c2[3] = 1), c2;
  }
  function mb(t3) {
    var r3 = [], i3 = [], n3 = -1;
    return t3.split(kt).forEach(function(t4) {
      var e3 = t4.match(tt) || [];
      r3.push.apply(r3, e3), i3.push(n3 += e3.length + 1);
    }), r3.c = i3, r3;
  }
  function nb(t3, e3, r3) {
    var i3, n3, a3, s3, o3 = "", u2 = (t3 + o3).match(kt), h3 = e3 ? "hsla(" : "rgba(", l3 = 0;
    if (!u2) return t3;
    if (u2 = u2.map(function(t4) {
      return (t4 = lb(t4, e3, 1)) && h3 + (e3 ? t4[0] + "," + t4[1] + "%," + t4[2] + "%," + t4[3] : t4.join(",")) + ")";
    }), r3 && (a3 = mb(t3), (i3 = r3.c).join(o3) !== a3.c.join(o3))) for (s3 = (n3 = t3.replace(kt, "1").split(tt)).length - 1; l3 < s3; l3++) o3 += n3[l3] + (~i3.indexOf(l3) ? u2.shift() || h3 + "0,0,0,0)" : (a3.length ? a3 : u2.length ? u2 : r3).shift());
    if (!n3) for (s3 = (n3 = t3.split(kt)).length - 1; l3 < s3; l3++) o3 += n3[l3] + u2[l3];
    return o3 + n3[s3];
  }
  function qb(t3) {
    var e3, r3 = t3.join(" ");
    if (kt.lastIndex = 0, kt.test(r3)) return e3 = Ot.test(r3), t3[1] = nb(t3[1], e3), t3[0] = nb(t3[0], e3, mb(t3[1])), true;
  }
  function yb(t3) {
    var e3 = (t3 + "").split("("), r3 = At[e3[0]];
    return r3 && 1 < e3.length && r3.config ? r3.config.apply(null, ~t3.indexOf("{") ? [(function _parseObjectInString(t4) {
      for (var e4, r4, i3, n3 = {}, a3 = t4.substr(1, t4.length - 3).split(":"), s3 = a3[0], o3 = 1, u2 = a3.length; o3 < u2; o3++) r4 = a3[o3], e4 = o3 !== u2 - 1 ? r4.lastIndexOf(",") : r4.length, i3 = r4.substr(0, e4), n3[s3] = isNaN(i3) ? i3.replace(St, "").trim() : +i3, s3 = r4.substr(e4 + 1).trim();
      return n3;
    })(e3[1])] : rt.exec(t3)[1].split(",").map(fa)) : At._CE && Pt.test(t3) ? At._CE("", t3) : r3;
  }
  function Ab(t3, e3) {
    for (var r3, i3 = t3._first; i3; ) i3 instanceof Rt ? Ab(i3, e3) : !i3.vars.yoyoEase || i3._yoyo && i3._repeat || i3._yoyo === e3 || (i3.timeline ? Ab(i3.timeline, e3) : (r3 = i3._ease, i3._ease = i3._yEase, i3._yEase = r3, i3._yoyo = e3)), i3 = i3._next;
  }
  function Cb(t3, e3, r3, i3) {
    void 0 === r3 && (r3 = function easeOut(t4) {
      return 1 - e3(1 - t4);
    }), void 0 === i3 && (i3 = function easeInOut(t4) {
      return t4 < 0.5 ? e3(2 * t4) / 2 : 1 - e3(2 * (1 - t4)) / 2;
    });
    var n3, a3 = { easeIn: e3, easeOut: r3, easeInOut: i3 };
    return _(t3, function(t4) {
      for (var e4 in At[t4] = at[t4] = a3, At[n3 = t4.toLowerCase()] = r3, a3) At[n3 + ("easeIn" === e4 ? ".in" : "easeOut" === e4 ? ".out" : ".inOut")] = At[t4 + "." + e4] = a3[e4];
    }), a3;
  }
  function Db(e3) {
    return function(t3) {
      return t3 < 0.5 ? (1 - e3(1 - 2 * t3)) / 2 : 0.5 + e3(2 * (t3 - 0.5)) / 2;
    };
  }
  function Eb(r3, t3, e3) {
    function il(t4) {
      return 1 === t4 ? 1 : i3 * Math.pow(2, -10 * t4) * Q((t4 - a3) * n3) + 1;
    }
    var i3 = 1 <= t3 ? t3 : 1, n3 = (e3 || (r3 ? 0.3 : 0.45)) / (t3 < 1 ? t3 : 1), a3 = n3 / E * (Math.asin(1 / i3) || 0), s3 = "out" === r3 ? il : "in" === r3 ? function(t4) {
      return 1 - il(1 - t4);
    } : Db(il);
    return n3 = E / n3, s3.config = function(t4, e4) {
      return Eb(r3, t4, e4);
    }, s3;
  }
  function Fb(e3, r3) {
    function ql(t4) {
      return t4 ? --t4 * t4 * ((r3 + 1) * t4 + r3) + 1 : 0;
    }
    void 0 === r3 && (r3 = 1.70158);
    var t3 = "out" === e3 ? ql : "in" === e3 ? function(t4) {
      return 1 - ql(1 - t4);
    } : Db(ql);
    return t3.config = function(t4) {
      return Fb(e3, t4);
    }, t3;
  }
  var I, i2, a2, h2, l2, f, d, c, m, g, v, y, T, b, w, x, k, C, A, P, S, D, F, U = { autoSleep: 120, force3D: "auto", nullTargetWarn: 1, units: { lineHeight: "" } }, R = { duration: 0.5, overwrite: false, delay: 0 }, z = 1e8, B = 1 / z, E = 2 * Math.PI, X = E / 4, V = 0, j = Math.sqrt, G = Math.cos, Q = Math.sin, J = Array.isArray, W = /(?:-?\.?\d|\.)+/gi, H = /[-+=.]*\d+[.e\-+]*\d*[e\-\+]*\d*/g, tt = /[-+=.]*\d+[.e-]*\d*[a-z%]*/g, et = /[-+=.]*\d+(?:\.|e-|e)*\d*/gi, rt = /\(([^()]+)\)/i, it = /[+-]=-?[\.\d]+/, nt = /[#\-+.]*\b[a-z\d-=+%.]+/gi, at = {}, st = {}, ot = [], ut = {}, ht = {}, lt = {}, ft = 30, dt = [], pt = "", ct = function _merge(t3, e3) {
    for (var r3 in e3) t3[r3] = e3[r3];
    return t3;
  }, _t = function _animationCycle(t3, e3) {
    return (t3 /= e3) && ~~t3 === t3 ? ~~t3 - 1 : ~~t3;
  }, mt = { _start: 0, endTime: O }, gt = function _clamp(t3, e3, r3) {
    return r3 < t3 ? t3 : e3 < r3 ? e3 : r3;
  }, vt = [].slice, yt = function toArray(t3, e3) {
    return !n2(t3) || e3 || !a2 && Ct() ? J(t3) ? (function _flatten(t4, e4, r3) {
      return void 0 === r3 && (r3 = []), t4.forEach(function(t5) {
        return n2(t5) && !e4 || Oa(t5, 1) ? r3.push.apply(r3, yt(t5)) : r3.push(t5);
      }) || r3;
    })(t3, e3) : Oa(t3) ? vt.call(t3, 0) : t3 ? [t3] : [] : vt.call(h2.querySelectorAll(t3), 0);
  }, Tt = function mapRange(e3, t3, r3, i3, n3) {
    var a3 = t3 - e3, s3 = i3 - r3;
    return Ja(n3, function(t4) {
      return r3 + ((t4 - e3) / a3 * s3 || 0);
    });
  }, bt = function _callback(t3, e3, r3) {
    var i3, n3, a3 = t3.vars, s3 = a3[e3];
    if (s3) return i3 = a3[e3 + "Params"], n3 = a3.callbackScope || t3, r3 && ot.length && da(), i3 ? s3.apply(n3, i3) : s3.call(n3);
  }, wt = 255, xt = { aqua: [0, wt, wt], lime: [0, wt, 0], silver: [192, 192, 192], black: [0, 0, 0], maroon: [128, 0, 0], teal: [0, 128, 128], blue: [0, 0, wt], navy: [0, 0, 128], white: [wt, wt, wt], olive: [128, 128, 0], yellow: [wt, wt, 0], orange: [wt, 165, 0], gray: [128, 128, 128], purple: [128, 0, 128], green: [0, 128, 0], red: [wt, 0, 0], pink: [wt, 192, 203], cyan: [0, wt, wt], transparent: [wt, wt, wt, 0] }, kt = (function() {
    var t3, e3 = "(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#(?:[0-9a-f]{3}){1,2}\\b";
    for (t3 in xt) e3 += "|" + t3 + "\\b";
    return new RegExp(e3 + ")", "gi");
  })(), Ot = /hsl[a]?\(/, Mt = (b = Date.now, w = 500, x = 33, k = b(), C = k, P = A = 1 / 240, T = { time: 0, frame: 0, tick: function tick() {
    kk(true);
  }, wake: function wake() {
    f && (!a2 && t2() && (i2 = a2 = window, h2 = i2.document || {}, at.gsap = ie, (i2.gsapVersions || (i2.gsapVersions = [])).push(ie.version), K(l2 || i2.GreenSockGlobals || !i2.gsap && i2 || {}), y = i2.requestAnimationFrame), g && T.sleep(), v = y || function(t3) {
      return setTimeout(t3, 1e3 * (P - T.time) + 1 | 0);
    }, m = 1, kk(2));
  }, sleep: function sleep() {
    (y ? i2.cancelAnimationFrame : clearTimeout)(g), m = 0, v = O;
  }, lagSmoothing: function lagSmoothing(t3, e3) {
    w = t3 || 1e8, x = Math.min(e3, w, 0);
  }, fps: function fps(t3) {
    A = 1 / (t3 || 240), P = T.time + A;
  }, add: function add(t3) {
    S.indexOf(t3) < 0 && S.push(t3), Ct();
  }, remove: function remove(t3) {
    var e3;
    ~(e3 = S.indexOf(t3)) && S.splice(e3, 1);
  }, _listeners: S = [] }), Ct = function _wake() {
    return !m && Mt.wake();
  }, At = {}, Pt = /^[\d.\-M][\d.\-,\s]/, St = /["']/g, Dt = function _invertEase(e3) {
    return function(t3) {
      return 1 - e3(1 - t3);
    };
  }, Ft = function _parseEase(t3, e3) {
    return t3 && (o2(t3) ? t3 : At[t3] || yb(t3)) || e3;
  };
  function kk(e3) {
    var t3, r3, i3 = b() - C, n3 = true === e3;
    w < i3 && (k += i3 - x), C += i3, T.time = (C - k) / 1e3, (0 < (t3 = T.time - P) || n3) && (T.frame++, P += t3 + (A <= t3 ? 4e-3 : A - t3), r3 = 1), n3 || (g = v(kk)), r3 && S.forEach(function(t4) {
      return t4(T.time, i3, T.frame, e3);
    });
  }
  function Hl(t3) {
    return t3 < F ? D * t3 * t3 : t3 < 0.7272727272727273 ? D * Math.pow(t3 - 1.5 / 2.75, 2) + 0.75 : t3 < 0.9090909090909092 ? D * (t3 -= 2.25 / 2.75) * t3 + 0.9375 : D * Math.pow(t3 - 2.625 / 2.75, 2) + 0.984375;
  }
  _("Linear,Quad,Cubic,Quart,Quint,Strong", function(t3, e3) {
    var r3 = e3 < 5 ? e3 + 1 : e3;
    Cb(t3 + ",Power" + (r3 - 1), e3 ? function(t4) {
      return Math.pow(t4, r3);
    } : function(t4) {
      return t4;
    }, function(t4) {
      return 1 - Math.pow(1 - t4, r3);
    }, function(t4) {
      return t4 < 0.5 ? Math.pow(2 * t4, r3) / 2 : 1 - Math.pow(2 * (1 - t4), r3) / 2;
    });
  }), At.Linear.easeNone = At.none = At.Linear.easeIn, Cb("Elastic", Eb("in"), Eb("out"), Eb()), D = 7.5625, F = 1 / 2.75, Cb("Bounce", function(t3) {
    return 1 - Hl(1 - t3);
  }, Hl), Cb("Expo", function(t3) {
    return t3 ? Math.pow(2, 10 * (t3 - 1)) : 0;
  }), Cb("Circ", function(t3) {
    return -(j(1 - t3 * t3) - 1);
  }), Cb("Sine", function(t3) {
    return 1 === t3 ? 1 : 1 - G(t3 * X);
  }), Cb("Back", Fb("in"), Fb("out"), Fb()), At.SteppedEase = At.steps = at.SteppedEase = { config: function config(t3, e3) {
    void 0 === t3 && (t3 = 1);
    var r3 = 1 / t3, i3 = t3 + (e3 ? 0 : 1), n3 = e3 ? 1 : 0;
    return function(t4) {
      return ((i3 * gt(0, 0.99999999, t4) | 0) + n3) * r3;
    };
  } }, R.ease = At["quad.out"], _("onComplete,onUpdate,onStart,onRepeat,onReverseComplete,onInterrupt", function(t3) {
    return pt += t3 + "," + t3 + "Params,";
  });
  var zt, Et = function GSCache(t3, e3) {
    this.id = V++, (t3._gsap = this).target = t3, this.harness = e3, this.get = e3 ? e3.get : $, this.set = e3 ? e3.getSetter : Gt;
  }, It = ((zt = Animation.prototype).delay = function delay(t3) {
    return t3 || 0 === t3 ? (this.parent && this.parent.smoothChildTiming && this.startTime(this._start + t3 - this._delay), this._delay = t3, this) : this._delay;
  }, zt.duration = function duration(t3) {
    return arguments.length ? this.totalDuration(0 < this._repeat ? t3 + (t3 + this._rDelay) * this._repeat : t3) : this.totalDuration() && this._dur;
  }, zt.totalDuration = function totalDuration(t3) {
    if (!arguments.length) return this._tDur;
    this._dirty = 0;
    var e3 = this._time / this._dur || 0;
    return Fa(this, this._repeat < 0 ? t3 : (t3 - this._repeat * this._rDelay) / (this._repeat + 1)), this._tTime ? ya(this, e3 * t3 + ua(this)) : this;
  }, zt.totalTime = function totalTime(t3, e3) {
    if (Ct(), !arguments.length) return this._tTime;
    var r3 = this._dp;
    if (r3 && r3.smoothChildTiming && this._ts) {
      for (ya(this, t3); r3.parent; ) r3.parent._time !== r3._start + (0 <= r3._ts ? r3._tTime / r3._ts : (r3.totalDuration() - r3._tTime) / -r3._ts) && r3.totalTime(r3._tTime, true), r3 = r3.parent;
      !this.parent && this._dp.autoRemoveChildren && (0 < this._ts && t3 < this._tDur || this._ts < 0 && 0 < t3 || !this._tDur && !t3) && Aa(this._dp, this, this._start - this._delay);
    }
    return (this._tTime !== t3 || !this._dur && !e3 || this._initted && Math.abs(this._zTime) === B || !t3 && !this._initted) && (this._ts || (this._pTime = t3), ea(this, t3, e3)), this;
  }, zt.time = function time(t3, e3) {
    return arguments.length ? this.totalTime(Math.min(this.totalDuration(), t3 + ua(this)) % this._dur || (t3 ? this._dur : 0), e3) : this._time;
  }, zt.totalProgress = function totalProgress(t3, e3) {
    return arguments.length ? this.totalTime(this.totalDuration() * t3, e3) : this.totalDuration() ? Math.min(1, this._tTime / this._tDur) : this.ratio;
  }, zt.progress = function progress(t3, e3) {
    return arguments.length ? this.totalTime(this.duration() * (!this._yoyo || 1 & this.iteration() ? t3 : 1 - t3) + ua(this), e3) : this.duration() ? Math.min(1, this._time / this._dur) : this.ratio;
  }, zt.iteration = function iteration(t3, e3) {
    var r3 = this.duration() + this._rDelay;
    return arguments.length ? this.totalTime(this._time + (t3 - 1) * r3, e3) : this._repeat ? _t(this._tTime, r3) + 1 : 1;
  }, zt.timeScale = function timeScale(t3) {
    if (!arguments.length) return this._rts === -B ? 0 : this._rts;
    if (this._rts === t3) return this;
    var e3 = this.parent && this._ts ? wa(this.parent._time, this) : this._tTime;
    return this._rts = +t3 || 0, this._ts = this._ps || t3 === -B ? 0 : this._rts, (function _recacheAncestors(t4) {
      for (var e4 = t4.parent; e4 && e4.parent; ) e4._dirty = 1, e4.totalDuration(), e4 = e4.parent;
      return t4;
    })(this.totalTime(gt(-this._delay, this._tDur, e3), true));
  }, zt.paused = function paused(t3) {
    return arguments.length ? (this._ps !== t3 && ((this._ps = t3) ? (this._pTime = this._tTime || Math.max(-this._delay, this.rawTime()), this._ts = this._act = 0) : (Ct(), this._ts = this._rts, this.totalTime(this.parent && !this.parent.smoothChildTiming ? this.rawTime() : this._tTime || this._pTime, 1 === this.progress() && (this._tTime -= B) && Math.abs(this._zTime) !== B))), this) : this._ps;
  }, zt.startTime = function startTime(t3) {
    if (arguments.length) {
      this._start = t3;
      var e3 = this.parent || this._dp;
      return !e3 || !e3._sort && this.parent || Aa(e3, this, t3 - this._delay), this;
    }
    return this._start;
  }, zt.endTime = function endTime(t3) {
    return this._start + (s2(t3) ? this.totalDuration() : this.duration()) / Math.abs(this._ts);
  }, zt.rawTime = function rawTime(t3) {
    var e3 = this.parent || this._dp;
    return e3 ? t3 && (!this._ts || this._repeat && this._time && this.totalProgress() < 1) ? this._tTime % (this._dur + this._rDelay) : this._ts ? wa(e3.rawTime(t3), this) : this._tTime : this._tTime;
  }, zt.globalTime = function globalTime(t3) {
    for (var e3 = this, r3 = arguments.length ? t3 : e3.rawTime(); e3; ) r3 = e3._start + r3 / (e3._ts || 1), e3 = e3._dp;
    return r3;
  }, zt.repeat = function repeat(t3) {
    return arguments.length ? (this._repeat = t3, Ga(this)) : this._repeat;
  }, zt.repeatDelay = function repeatDelay(t3) {
    return arguments.length ? (this._rDelay = t3, Ga(this)) : this._rDelay;
  }, zt.yoyo = function yoyo(t3) {
    return arguments.length ? (this._yoyo = t3, this) : this._yoyo;
  }, zt.seek = function seek(t3, e3) {
    return this.totalTime(Ia(this, t3), s2(e3));
  }, zt.restart = function restart(t3, e3) {
    return this.play().totalTime(t3 ? -this._delay : 0, s2(e3));
  }, zt.play = function play(t3, e3) {
    return null != t3 && this.seek(t3, e3), this.reversed(false).paused(false);
  }, zt.reverse = function reverse(t3, e3) {
    return null != t3 && this.seek(t3 || this.totalDuration(), e3), this.reversed(true).paused(false);
  }, zt.pause = function pause(t3, e3) {
    return null != t3 && this.seek(t3, e3), this.paused(true);
  }, zt.resume = function resume() {
    return this.paused(false);
  }, zt.reversed = function reversed(t3) {
    return arguments.length ? (!!t3 !== this.reversed() && this.timeScale(-this._rts || (t3 ? -B : 0)), this) : this._rts < 0;
  }, zt.invalidate = function invalidate() {
    return this._initted = 0, this._zTime = -B, this;
  }, zt.isActive = function isActive() {
    var t3, e3 = this.parent || this._dp, r3 = this._start;
    return !(e3 && !(this._ts && this._initted && e3.isActive() && (t3 = e3.rawTime(true)) >= r3 && t3 < this.endTime(true) - B));
  }, zt.eventCallback = function eventCallback(t3, e3, r3) {
    var i3 = this.vars;
    return 1 < arguments.length ? (e3 ? (i3[t3] = e3, r3 && (i3[t3 + "Params"] = r3), "onUpdate" === t3 && (this._onUpdate = e3)) : delete i3[t3], this) : i3[t3];
  }, zt.then = function then(t3) {
    var i3 = this;
    return new Promise(function(e3) {
      function Zm() {
        var t4 = i3.then;
        i3.then = null, o2(r3) && (r3 = r3(i3)) && (r3.then || r3 === i3) && (i3.then = t4), e3(r3), i3.then = t4;
      }
      var r3 = o2(t3) ? t3 : ga;
      i3._initted && 1 === i3.totalProgress() && 0 <= i3._ts || !i3._tTime && i3._ts < 0 ? Zm() : i3._prom = Zm;
    });
  }, zt.kill = function kill() {
    fb(this);
  }, Animation);
  function Animation(t3, e3) {
    var r3 = t3.parent || I;
    this.vars = t3, this._delay = +t3.delay || 0, (this._repeat = t3.repeat || 0) && (this._rDelay = t3.repeatDelay || 0, this._yoyo = !!t3.yoyo || !!t3.yoyoEase), this._ts = 1, Fa(this, +t3.duration, 1), this.data = t3.data, m || Mt.wake(), r3 && Aa(r3, this, e3 || 0 === e3 ? e3 : r3._time, 1), t3.reversed && this.reverse(), t3.paused && this.paused(true);
  }
  ha(It.prototype, { _time: 0, _start: 0, _end: 0, _tTime: 0, _tDur: 0, _dirty: 0, _repeat: 0, _yoyo: false, parent: null, _initted: false, _rDelay: 0, _ts: 1, _dp: 0, ratio: 0, _zTime: -B, _prom: 0, _ps: false, _rts: 1 });
  var Rt = (function(i3) {
    function Timeline(t4, e3) {
      var r3;
      return void 0 === t4 && (t4 = {}), (r3 = i3.call(this, t4, e3) || this).labels = {}, r3.smoothChildTiming = !!t4.smoothChildTiming, r3.autoRemoveChildren = !!t4.autoRemoveChildren, r3._sort = s2(t4.sortChildren), r3.parent && za(r3.parent, _assertThisInitialized(r3)), t4.scrollTrigger && Ba(_assertThisInitialized(r3), t4.scrollTrigger), r3;
    }
    _inheritsLoose(Timeline, i3);
    var t3 = Timeline.prototype;
    return t3.to = function to(t4, e3, r3, i4) {
      return new Xt(t4, ca(arguments, 0, this), Ia(this, p(e3) ? i4 : r3)), this;
    }, t3.from = function from(t4, e3, r3, i4) {
      return new Xt(t4, ca(arguments, 1, this), Ia(this, p(e3) ? i4 : r3)), this;
    }, t3.fromTo = function fromTo(t4, e3, r3, i4, n3) {
      return new Xt(t4, ca(arguments, 2, this), Ia(this, p(e3) ? n3 : i4)), this;
    }, t3.set = function set(t4, e3, r3) {
      return e3.duration = 0, e3.parent = this, ma(e3).repeatDelay || (e3.repeat = 0), e3.immediateRender = !!e3.immediateRender, new Xt(t4, e3, Ia(this, r3), 1), this;
    }, t3.call = function call(t4, e3, r3) {
      return Aa(this, Xt.delayedCall(0, t4, e3), Ia(this, r3));
    }, t3.staggerTo = function staggerTo(t4, e3, r3, i4, n3, a3, s3) {
      return r3.duration = e3, r3.stagger = r3.stagger || i4, r3.onComplete = a3, r3.onCompleteParams = s3, r3.parent = this, new Xt(t4, r3, Ia(this, n3)), this;
    }, t3.staggerFrom = function staggerFrom(t4, e3, r3, i4, n3, a3, o3) {
      return r3.runBackwards = 1, ma(r3).immediateRender = s2(r3.immediateRender), this.staggerTo(t4, e3, r3, i4, n3, a3, o3);
    }, t3.staggerFromTo = function staggerFromTo(t4, e3, r3, i4, n3, a3, o3, u2) {
      return i4.startAt = r3, ma(i4).immediateRender = s2(i4.immediateRender), this.staggerTo(t4, e3, i4, n3, a3, o3, u2);
    }, t3.render = function render(t4, e3, r3) {
      var i4, n3, a3, s3, o3, u2, h3, l3, f2, d2, p2, c2, _2 = this._time, m2 = this._dirty ? this.totalDuration() : this._tDur, g2 = this._dur, v2 = this !== I && m2 - B < t4 && 0 <= t4 ? m2 : t4 < B ? 0 : t4, y2 = this._zTime < 0 != t4 < 0 && (this._initted || !g2);
      if (v2 !== this._tTime || r3 || y2) {
        if (_2 !== this._time && g2 && (v2 += this._time - _2, t4 += this._time - _2), i4 = v2, f2 = this._start, u2 = !(l3 = this._ts), y2 && (g2 || (_2 = this._zTime), !t4 && e3 || (this._zTime = t4)), this._repeat && (p2 = this._yoyo, o3 = g2 + this._rDelay, (g2 < (i4 = aa(v2 % o3)) || m2 === v2) && (i4 = g2), (s3 = ~~(v2 / o3)) && s3 === v2 / o3 && (i4 = g2, s3--), d2 = _t(this._tTime, o3), !_2 && this._tTime && d2 !== s3 && (d2 = s3), p2 && 1 & s3 && (i4 = g2 - i4, c2 = 1), s3 !== d2 && !this._lock)) {
          var T2 = p2 && 1 & d2, b2 = T2 === (p2 && 1 & s3);
          if (s3 < d2 && (T2 = !T2), _2 = T2 ? 0 : g2, this._lock = 1, this.render(_2 || (c2 ? 0 : aa(s3 * o3)), e3, !g2)._lock = 0, !e3 && this.parent && bt(this, "onRepeat"), this.vars.repeatRefresh && !c2 && (this.invalidate()._lock = 1), _2 !== this._time || u2 != !this._ts) return this;
          if (b2 && (this._lock = 2, _2 = T2 ? g2 + 1e-4 : -1e-4, this.render(_2, true), this.vars.repeatRefresh && !c2 && this.invalidate()), this._lock = 0, !this._ts && !u2) return this;
          Ab(this, c2);
        }
        if (this._hasPause && !this._forcing && this._lock < 2 && (h3 = (function _findNextPauseTween(t5, e4, r4) {
          var i5;
          if (e4 < r4) for (i5 = t5._first; i5 && i5._start <= r4; ) {
            if (!i5._dur && "isPause" === i5.data && i5._start > e4) return i5;
            i5 = i5._next;
          }
          else for (i5 = t5._last; i5 && i5._start >= r4; ) {
            if (!i5._dur && "isPause" === i5.data && i5._start < e4) return i5;
            i5 = i5._prev;
          }
        })(this, aa(_2), aa(i4))) && (v2 -= i4 - (i4 = h3._start)), this._tTime = v2, this._time = i4, this._act = !l3, this._initted || (this._onUpdate = this.vars.onUpdate, this._initted = 1, this._zTime = t4), _2 || !i4 || e3 || bt(this, "onStart"), _2 <= i4 && 0 <= t4) for (n3 = this._first; n3; ) {
          if (a3 = n3._next, (n3._act || i4 >= n3._start) && n3._ts && h3 !== n3) {
            if (n3.parent !== this) return this.render(t4, e3, r3);
            if (n3.render(0 < n3._ts ? (i4 - n3._start) * n3._ts : (n3._dirty ? n3.totalDuration() : n3._tDur) + (i4 - n3._start) * n3._ts, e3, r3), i4 !== this._time || !this._ts && !u2) {
              h3 = 0, a3 && (v2 += this._zTime = -B);
              break;
            }
          }
          n3 = a3;
        }
        else {
          n3 = this._last;
          for (var w2 = t4 < 0 ? t4 : i4; n3; ) {
            if (a3 = n3._prev, (n3._act || w2 <= n3._end) && n3._ts && h3 !== n3) {
              if (n3.parent !== this) return this.render(t4, e3, r3);
              if (n3.render(0 < n3._ts ? (w2 - n3._start) * n3._ts : (n3._dirty ? n3.totalDuration() : n3._tDur) + (w2 - n3._start) * n3._ts, e3, r3), i4 !== this._time || !this._ts && !u2) {
                h3 = 0, a3 && (v2 += this._zTime = w2 ? -B : B);
                break;
              }
            }
            n3 = a3;
          }
        }
        if (h3 && !e3 && (this.pause(), h3.render(_2 <= i4 ? 0 : -B)._zTime = _2 <= i4 ? 1 : -1, this._ts)) return this._start = f2, xa(this), this.render(t4, e3, r3);
        this._onUpdate && !e3 && bt(this, "onUpdate", true), (v2 === m2 && m2 >= this.totalDuration() || !v2 && _2) && (f2 !== this._start && Math.abs(l3) === Math.abs(this._ts) || this._lock || (!t4 && g2 || !(v2 === m2 && 0 < this._ts || !v2 && this._ts < 0) || qa(this, 1), e3 || t4 < 0 && !_2 || !v2 && !_2 || (bt(this, v2 === m2 ? "onComplete" : "onReverseComplete", true), !this._prom || v2 < m2 && 0 < this.timeScale() || this._prom())));
      }
      return this;
    }, t3.add = function add(t4, e3) {
      var r3 = this;
      if (p(e3) || (e3 = Ia(this, e3)), !(t4 instanceof It)) {
        if (J(t4)) return t4.forEach(function(t5) {
          return r3.add(t5, e3);
        }), ra(this);
        if (n2(t4)) return this.addLabel(t4, e3);
        if (!o2(t4)) return this;
        t4 = Xt.delayedCall(0, t4);
      }
      return this !== t4 ? Aa(this, t4, e3) : this;
    }, t3.getChildren = function getChildren(t4, e3, r3, i4) {
      void 0 === t4 && (t4 = true), void 0 === e3 && (e3 = true), void 0 === r3 && (r3 = true), void 0 === i4 && (i4 = -z);
      for (var n3 = [], a3 = this._first; a3; ) a3._start >= i4 && (a3 instanceof Xt ? e3 && n3.push(a3) : (r3 && n3.push(a3), t4 && n3.push.apply(n3, a3.getChildren(true, e3, r3)))), a3 = a3._next;
      return n3;
    }, t3.getById = function getById(t4) {
      for (var e3 = this.getChildren(1, 1, 1), r3 = e3.length; r3--; ) if (e3[r3].vars.id === t4) return e3[r3];
    }, t3.remove = function remove(t4) {
      return n2(t4) ? this.removeLabel(t4) : o2(t4) ? this.killTweensOf(t4) : (pa(this, t4), t4 === this._recent && (this._recent = this._last), ra(this));
    }, t3.totalTime = function totalTime(t4, e3) {
      return arguments.length ? (this._forcing = 1, !this._dp && this._ts && (this._start = aa(Mt.time - (0 < this._ts ? t4 / this._ts : (this.totalDuration() - t4) / -this._ts))), i3.prototype.totalTime.call(this, t4, e3), this._forcing = 0, this) : this._tTime;
    }, t3.addLabel = function addLabel(t4, e3) {
      return this.labels[t4] = Ia(this, e3), this;
    }, t3.removeLabel = function removeLabel(t4) {
      return delete this.labels[t4], this;
    }, t3.addPause = function addPause(t4, e3, r3) {
      var i4 = Xt.delayedCall(0, e3 || O, r3);
      return i4.data = "isPause", this._hasPause = 1, Aa(this, i4, Ia(this, t4));
    }, t3.removePause = function removePause(t4) {
      var e3 = this._first;
      for (t4 = Ia(this, t4); e3; ) e3._start === t4 && "isPause" === e3.data && qa(e3), e3 = e3._next;
    }, t3.killTweensOf = function killTweensOf(t4, e3, r3) {
      for (var i4 = this.getTweensOf(t4, r3), n3 = i4.length; n3--; ) Lt !== i4[n3] && i4[n3].kill(t4, e3);
      return this;
    }, t3.getTweensOf = function getTweensOf(t4, e3) {
      for (var r3, i4 = [], n3 = yt(t4), a3 = this._first, s3 = p(e3); a3; ) a3 instanceof Xt ? ba(a3._targets, n3) && (s3 ? (!Lt || a3._initted && a3._ts) && a3.globalTime(0) <= e3 && a3.globalTime(a3.totalDuration()) > e3 : !e3 || a3.isActive()) && i4.push(a3) : (r3 = a3.getTweensOf(n3, e3)).length && i4.push.apply(i4, r3), a3 = a3._next;
      return i4;
    }, t3.tweenTo = function tweenTo(t4, e3) {
      e3 = e3 || {};
      var r3 = this, i4 = Ia(r3, t4), n3 = e3.startAt, a3 = e3.onStart, s3 = e3.onStartParams, o3 = Xt.to(r3, ha(e3, { ease: "none", lazy: false, time: i4, duration: e3.duration || Math.abs((i4 - (n3 && "time" in n3 ? n3.time : r3._time)) / r3.timeScale()) || B, onStart: function onStart() {
        r3.pause();
        var t5 = e3.duration || Math.abs((i4 - r3._time) / r3.timeScale());
        o3._dur !== t5 && Fa(o3, t5).render(o3._time, true, true), a3 && a3.apply(o3, s3 || []);
      } }));
      return o3;
    }, t3.tweenFromTo = function tweenFromTo(t4, e3, r3) {
      return this.tweenTo(e3, ha({ startAt: { time: Ia(this, t4) } }, r3));
    }, t3.recent = function recent() {
      return this._recent;
    }, t3.nextLabel = function nextLabel(t4) {
      return void 0 === t4 && (t4 = this._time), db(this, Ia(this, t4));
    }, t3.previousLabel = function previousLabel(t4) {
      return void 0 === t4 && (t4 = this._time), db(this, Ia(this, t4), 1);
    }, t3.currentLabel = function currentLabel(t4) {
      return arguments.length ? this.seek(t4, true) : this.previousLabel(this._time + B);
    }, t3.shiftChildren = function shiftChildren(t4, e3, r3) {
      void 0 === r3 && (r3 = 0);
      for (var i4, n3 = this._first, a3 = this.labels; n3; ) n3._start >= r3 && (n3._start += t4), n3 = n3._next;
      if (e3) for (i4 in a3) a3[i4] >= r3 && (a3[i4] += t4);
      return ra(this);
    }, t3.invalidate = function invalidate() {
      var t4 = this._first;
      for (this._lock = 0; t4; ) t4.invalidate(), t4 = t4._next;
      return i3.prototype.invalidate.call(this);
    }, t3.clear = function clear(t4) {
      void 0 === t4 && (t4 = true);
      for (var e3, r3 = this._first; r3; ) e3 = r3._next, this.remove(r3), r3 = e3;
      return this._time = this._tTime = this._pTime = 0, t4 && (this.labels = {}), ra(this);
    }, t3.totalDuration = function totalDuration(t4) {
      var e3, r3, i4, n3, a3 = 0, s3 = this, o3 = s3._last, u2 = z;
      if (arguments.length) return s3.timeScale((s3._repeat < 0 ? s3.duration() : s3.totalDuration()) / (s3.reversed() ? -t4 : t4));
      if (s3._dirty) {
        for (n3 = s3.parent; o3; ) e3 = o3._prev, o3._dirty && o3.totalDuration(), u2 < (i4 = o3._start) && s3._sort && o3._ts && !s3._lock ? (s3._lock = 1, Aa(s3, o3, i4 - o3._delay, 1)._lock = 0) : u2 = i4, i4 < 0 && o3._ts && (a3 -= i4, (!n3 && !s3._dp || n3 && n3.smoothChildTiming) && (s3._start += i4 / s3._ts, s3._time -= i4, s3._tTime -= i4), s3.shiftChildren(-i4, false, -Infinity), u2 = 0), a3 < (r3 = xa(o3)) && o3._ts && (a3 = r3), o3 = e3;
        Fa(s3, s3 === I && s3._time > a3 ? s3._time : a3, 1), s3._dirty = 0;
      }
      return s3._tDur;
    }, Timeline.updateRoot = function updateRoot(t4) {
      if (I._ts && (ea(I, wa(t4, I)), d = Mt.frame), Mt.frame >= ft) {
        ft += U.autoSleep || 120;
        var e3 = I._first;
        if ((!e3 || !e3._ts) && U.autoSleep && Mt._listeners.length < 2) {
          for (; e3 && !e3._ts; ) e3 = e3._next;
          e3 || Mt.sleep();
        }
      }
    }, Timeline;
  })(It);
  ha(Rt.prototype, { _lock: 0, _hasPause: 0, _forcing: 0 });
  function Mb(t3, e3, i3, a3, s3, u2) {
    var h3, l3, f2, d2;
    if (ht[t3] && false !== (h3 = new ht[t3]()).init(s3, h3.rawVars ? e3[t3] : (function _processVars(t4, e4, i4, a4, s4) {
      if (o2(t4) && (t4 = Yt(t4, s4, e4, i4, a4)), !r2(t4) || t4.style && t4.nodeType || J(t4)) return n2(t4) ? Yt(t4, s4, e4, i4, a4) : t4;
      var u3, h4 = {};
      for (u3 in t4) h4[u3] = Yt(t4[u3], s4, e4, i4, a4);
      return h4;
    })(e3[t3], a3, s3, u2, i3), i3, a3, u2) && (i3._pt = l3 = new ee(i3._pt, s3, t3, 0, 1, h3.render, h3, 0, h3.priority), i3 !== c)) for (f2 = i3._ptLookup[i3._targets.indexOf(s3)], d2 = h3._props.length; d2--; ) f2[h3._props[d2]] = l3;
    return h3;
  }
  var Lt, Bt = function _addPropTween(t3, e3, r3, i3, a3, s3, u2, h3, l3) {
    o2(i3) && (i3 = i3(a3 || 0, t3, s3));
    var f2, d2 = t3[e3], p2 = "get" !== r3 ? r3 : o2(d2) ? l3 ? t3[e3.indexOf("set") || !o2(t3["get" + e3.substr(3)]) ? e3 : "get" + e3.substr(3)](l3) : t3[e3]() : d2, c2 = o2(d2) ? l3 ? jt : Vt : Zt;
    if (n2(i3) && (~i3.indexOf("random(") && (i3 = ab(i3)), "=" === i3.charAt(1) && (i3 = parseFloat(p2) + parseFloat(i3.substr(2)) * ("-" === i3.charAt(0) ? -1 : 1) + (La(p2) || 0))), p2 !== i3) return isNaN(p2 * i3) ? (d2 || e3 in t3 || L(e3, i3), function _addComplexStringPropTween(t4, e4, r4, i4, n3, a4, s4) {
      var o3, u3, h4, l4, f3, d3, p3, c3, _2 = new ee(this._pt, t4, e4, 0, 1, Wt, null, n3), m2 = 0, g2 = 0;
      for (_2.b = r4, _2.e = i4, r4 += "", (p3 = ~(i4 += "").indexOf("random(")) && (i4 = ab(i4)), a4 && (a4(c3 = [r4, i4], t4, e4), r4 = c3[0], i4 = c3[1]), u3 = r4.match(et) || []; o3 = et.exec(i4); ) l4 = o3[0], f3 = i4.substring(m2, o3.index), h4 ? h4 = (h4 + 1) % 5 : "rgba(" === f3.substr(-5) && (h4 = 1), l4 !== u3[g2++] && (d3 = parseFloat(u3[g2 - 1]) || 0, _2._pt = { _next: _2._pt, p: f3 || 1 === g2 ? f3 : ",", s: d3, c: "=" === l4.charAt(1) ? parseFloat(l4.substr(2)) * ("-" === l4.charAt(0) ? -1 : 1) : parseFloat(l4) - d3, m: h4 && h4 < 4 ? Math.round : 0 }, m2 = et.lastIndex);
      return _2.c = m2 < i4.length ? i4.substring(m2, i4.length) : "", _2.fp = s4, (it.test(i4) || p3) && (_2.e = 0), this._pt = _2;
    }.call(this, t3, e3, p2, i3, c2, h3 || U.stringFilter, l3)) : (f2 = new ee(this._pt, t3, e3, +p2 || 0, i3 - (p2 || 0), "boolean" == typeof d2 ? Jt : Qt, 0, c2), l3 && (f2.fp = l3), u2 && f2.modifier(u2, this, t3), this._pt = f2);
  }, qt = function _initTween(t3, e3) {
    var r3, i3, n3, a3, o3, u2, h3, l3, f2, d2, p2, c2, _2, m2 = t3.vars, g2 = m2.ease, v2 = m2.startAt, y2 = m2.immediateRender, T2 = m2.lazy, b2 = m2.onUpdate, w2 = m2.onUpdateParams, x2 = m2.callbackScope, k2 = m2.runBackwards, O2 = m2.yoyoEase, M2 = m2.keyframes, C2 = m2.autoRevert, A2 = t3._dur, P2 = t3._startAt, S2 = t3._targets, D2 = t3.parent, F2 = D2 && "nested" === D2.data ? D2.parent._targets : S2, z2 = "auto" === t3._overwrite, E2 = t3.timeline;
    if (!E2 || M2 && g2 || (g2 = "none"), t3._ease = Ft(g2, R.ease), t3._yEase = O2 ? Dt(Ft(true === O2 ? g2 : O2, R.ease)) : 0, O2 && t3._yoyo && !t3._repeat && (O2 = t3._yEase, t3._yEase = t3._ease, t3._ease = O2), !E2) {
      if (c2 = (l3 = S2[0] ? Z(S2[0]).harness : 0) && m2[l3.prop], r3 = la(m2, st), P2 && P2.render(-1, true).kill(), v2) {
        if (qa(t3._startAt = Xt.set(S2, ha({ data: "isStart", overwrite: false, parent: D2, immediateRender: true, lazy: s2(T2), startAt: null, delay: 0, onUpdate: b2, onUpdateParams: w2, callbackScope: x2, stagger: 0 }, v2))), y2) {
          if (0 < e3) C2 || (t3._startAt = 0);
          else if (A2 && !(e3 < 0 && P2)) return void (t3._zTime = e3);
        }
      } else if (k2 && A2) if (P2) C2 || (t3._startAt = 0);
      else if (e3 && (y2 = false), n3 = ha({ overwrite: false, data: "isFromStart", lazy: y2 && s2(T2), immediateRender: y2, stagger: 0, parent: D2 }, r3), c2 && (n3[l3.prop] = c2), qa(t3._startAt = Xt.set(S2, n3)), y2) {
        if (!e3) return;
      } else _initTween(t3._startAt, B);
      for (t3._pt = 0, T2 = A2 && s2(T2) || T2 && !A2, i3 = 0; i3 < S2.length; i3++) {
        if (h3 = (o3 = S2[i3])._gsap || Y(S2)[i3]._gsap, t3._ptLookup[i3] = d2 = {}, ut[h3.id] && da(), p2 = F2 === S2 ? i3 : F2.indexOf(o3), l3 && false !== (f2 = new l3()).init(o3, c2 || r3, t3, p2, F2) && (t3._pt = a3 = new ee(t3._pt, o3, f2.name, 0, 1, f2.render, f2, 0, f2.priority), f2._props.forEach(function(t4) {
          d2[t4] = a3;
        }), f2.priority && (u2 = 1)), !l3 || c2) for (n3 in r3) ht[n3] && (f2 = Mb(n3, r3, t3, p2, o3, F2)) ? f2.priority && (u2 = 1) : d2[n3] = a3 = Bt.call(t3, o3, n3, "get", r3[n3], p2, F2, 0, m2.stringFilter);
        t3._op && t3._op[i3] && t3.kill(o3, t3._op[i3]), z2 && t3._pt && (Lt = t3, I.killTweensOf(o3, d2, t3.globalTime(0)), _2 = !t3.parent, Lt = 0), t3._pt && T2 && (ut[h3.id] = 1);
      }
      u2 && te(t3), t3._onInit && t3._onInit(t3);
    }
    t3._from = !E2 && !!m2.runBackwards, t3._onUpdate = b2, t3._initted = (!t3._op || t3._pt) && !_2;
  }, Yt = function _parseFuncOrString(t3, e3, r3, i3, a3) {
    return o2(t3) ? t3.call(e3, r3, i3, a3) : n2(t3) && ~t3.indexOf("random(") ? ab(t3) : t3;
  }, Nt = pt + "repeat,repeatDelay,yoyo,repeatRefresh,yoyoEase", Ut = (Nt + ",id,stagger,delay,duration,paused,scrollTrigger").split(","), Xt = (function(D2) {
    function Tween(t4, e3, i3, n3) {
      var a3;
      "number" == typeof e3 && (i3.duration = e3, e3 = i3, i3 = null);
      var o3, h3, l3, f2, d2, c2, _2, m2, g2 = (a3 = D2.call(this, n3 ? e3 : ma(e3), i3) || this).vars, v2 = g2.duration, y2 = g2.delay, T2 = g2.immediateRender, b2 = g2.stagger, w2 = g2.overwrite, x2 = g2.keyframes, k2 = g2.defaults, C2 = g2.scrollTrigger, A2 = g2.yoyoEase, P2 = a3.parent, S2 = (J(t4) ? p(t4[0]) : "length" in e3) ? [t4] : yt(t4);
      if (a3._targets = S2.length ? Y(S2) : M("GSAP target " + t4 + " not found. https://greensock.com", !U.nullTargetWarn) || [], a3._ptLookup = [], a3._overwrite = w2, x2 || b2 || u(v2) || u(y2)) {
        if (e3 = a3.vars, (o3 = a3.timeline = new Rt({ data: "nested", defaults: k2 || {} })).kill(), o3.parent = _assertThisInitialized(a3), x2) ha(o3.vars.defaults, { ease: "none" }), x2.forEach(function(t5) {
          return o3.to(S2, t5, ">");
        });
        else {
          if (f2 = S2.length, _2 = b2 ? Sa(b2) : O, r2(b2)) for (d2 in b2) ~Nt.indexOf(d2) && ((m2 = m2 || {})[d2] = b2[d2]);
          for (h3 = 0; h3 < f2; h3++) {
            for (d2 in l3 = {}, e3) Ut.indexOf(d2) < 0 && (l3[d2] = e3[d2]);
            l3.stagger = 0, A2 && (l3.yoyoEase = A2), m2 && ct(l3, m2), c2 = S2[h3], l3.duration = +Yt(v2, _assertThisInitialized(a3), h3, c2, S2), l3.delay = (+Yt(y2, _assertThisInitialized(a3), h3, c2, S2) || 0) - a3._delay, !b2 && 1 === f2 && l3.delay && (a3._delay = y2 = l3.delay, a3._start += y2, l3.delay = 0), o3.to(c2, l3, _2(h3, c2, S2));
          }
          o3.duration() ? v2 = y2 = 0 : a3.timeline = 0;
        }
        v2 || a3.duration(v2 = o3.duration());
      } else a3.timeline = 0;
      return true === w2 && (Lt = _assertThisInitialized(a3), I.killTweensOf(S2), Lt = 0), P2 && za(P2, _assertThisInitialized(a3)), (T2 || !v2 && !x2 && a3._start === aa(P2._time) && s2(T2) && (function _hasNoPausedAncestors(t5) {
        return !t5 || t5._ts && _hasNoPausedAncestors(t5.parent);
      })(_assertThisInitialized(a3)) && "nested" !== P2.data) && (a3._tTime = -B, a3.render(Math.max(0, -y2))), C2 && Ba(_assertThisInitialized(a3), C2), a3;
    }
    _inheritsLoose(Tween, D2);
    var t3 = Tween.prototype;
    return t3.render = function render(t4, e3, r3) {
      var i3, n3, a3, s3, o3, u2, h3, l3, f2, d2 = this._time, p2 = this._tDur, c2 = this._dur, _2 = p2 - B < t4 && 0 <= t4 ? p2 : t4 < B ? 0 : t4;
      if (c2) {
        if (_2 !== this._tTime || !t4 || r3 || this._startAt && this._zTime < 0 != t4 < 0) {
          if (i3 = _2, l3 = this.timeline, this._repeat) {
            if (s3 = c2 + this._rDelay, (c2 < (i3 = aa(_2 % s3)) || p2 === _2) && (i3 = c2), (a3 = ~~(_2 / s3)) && a3 === _2 / s3 && (i3 = c2, a3--), (u2 = this._yoyo && 1 & a3) && (f2 = this._yEase, i3 = c2 - i3), o3 = _t(this._tTime, s3), i3 === d2 && !r3 && this._initted) return this;
            a3 !== o3 && (l3 && this._yEase && Ab(l3, u2), !this.vars.repeatRefresh || u2 || this._lock || (this._lock = r3 = 1, this.render(aa(s3 * a3), true).invalidate()._lock = 0));
          }
          if (!this._initted) {
            if (Ca(this, t4 < 0 ? t4 : i3, r3, e3)) return this._tTime = 0, this;
            if (c2 !== this._dur) return this.render(t4, e3, r3);
          }
          for (this._tTime = _2, this._time = i3, !this._act && this._ts && (this._act = 1, this._lazy = 0), this.ratio = h3 = (f2 || this._ease)(i3 / c2), this._from && (this.ratio = h3 = 1 - h3), !i3 || d2 || e3 || bt(this, "onStart"), n3 = this._pt; n3; ) n3.r(h3, n3.d), n3 = n3._next;
          l3 && l3.render(t4 < 0 ? t4 : !i3 && u2 ? -B : l3._dur * h3, e3, r3) || this._startAt && (this._zTime = t4), this._onUpdate && !e3 && (t4 < 0 && this._startAt && this._startAt.render(t4, true, r3), bt(this, "onUpdate")), this._repeat && a3 !== o3 && this.vars.onRepeat && !e3 && this.parent && bt(this, "onRepeat"), _2 !== this._tDur && _2 || this._tTime !== _2 || (t4 < 0 && this._startAt && !this._onUpdate && this._startAt.render(t4, true, true), !t4 && c2 || !(_2 === this._tDur && 0 < this._ts || !_2 && this._ts < 0) || qa(this, 1), e3 || t4 < 0 && !d2 || !_2 && !d2 || (bt(this, _2 === p2 ? "onComplete" : "onReverseComplete", true), !this._prom || _2 < p2 && 0 < this.timeScale() || this._prom()));
        }
      } else !(function _renderZeroDurationTween(t5, e4, r4, i4) {
        var n4, a4, s4 = t5.ratio, o4 = e4 < 0 || !e4 && s4 && !t5._start && t5._zTime > B && !t5._dp._lock || t5._ts < 0 || t5._dp._ts < 0 ? 0 : 1, u3 = t5._rDelay, h4 = 0;
        if (u3 && t5._repeat && (h4 = gt(0, t5._tDur, e4), _t(h4, u3) !== (a4 = _t(t5._tTime, u3)) && (s4 = 1 - o4, t5.vars.repeatRefresh && t5._initted && t5.invalidate())), t5._initted || !Ca(t5, e4, i4, r4)) if (o4 !== s4 || i4 || t5._zTime === B || !e4 && t5._zTime) {
          for (a4 = t5._zTime, t5._zTime = e4 || (r4 ? B : 0), r4 = r4 || e4 && !a4, t5.ratio = o4, t5._from && (o4 = 1 - o4), t5._time = 0, t5._tTime = h4, r4 || bt(t5, "onStart"), n4 = t5._pt; n4; ) n4.r(o4, n4.d), n4 = n4._next;
          t5._startAt && e4 < 0 && t5._startAt.render(e4, true, true), t5._onUpdate && !r4 && bt(t5, "onUpdate"), h4 && t5._repeat && !r4 && t5.parent && bt(t5, "onRepeat"), (e4 >= t5._tDur || e4 < 0) && t5.ratio === o4 && (o4 && qa(t5, 1), r4 || (bt(t5, o4 ? "onComplete" : "onReverseComplete", true), t5._prom && t5._prom()));
        } else t5._zTime || (t5._zTime = e4);
      })(this, t4, e3, r3);
      return this;
    }, t3.targets = function targets() {
      return this._targets;
    }, t3.invalidate = function invalidate() {
      return this._pt = this._op = this._startAt = this._onUpdate = this._act = this._lazy = 0, this._ptLookup = [], this.timeline && this.timeline.invalidate(), D2.prototype.invalidate.call(this);
    }, t3.kill = function kill(t4, e3) {
      if (void 0 === e3 && (e3 = "all"), !(t4 || e3 && "all" !== e3) && (this._lazy = 0, this.parent)) return fb(this);
      if (this.timeline) {
        var r3 = this.timeline.totalDuration();
        return this.timeline.killTweensOf(t4, e3, Lt && true !== Lt.vars.overwrite)._first || fb(this), this.parent && r3 !== this.timeline.totalDuration() && Fa(this, this._dur * this.timeline._tDur / r3), this;
      }
      var i3, a3, s3, o3, u2, h3, l3, f2 = this._targets, d2 = t4 ? yt(t4) : f2, p2 = this._ptLookup, c2 = this._pt;
      if ((!e3 || "all" === e3) && (function _arraysMatch(t5, e4) {
        for (var r4 = t5.length, i4 = r4 === e4.length; i4 && r4-- && t5[r4] === e4[r4]; ) ;
        return r4 < 0;
      })(f2, d2)) return "all" === e3 && (this._pt = 0), fb(this);
      for (i3 = this._op = this._op || [], "all" !== e3 && (n2(e3) && (u2 = {}, _(e3, function(t5) {
        return u2[t5] = 1;
      }), e3 = u2), e3 = (function _addAliasesToVars(t5, e4) {
        var r4, i4, n3, a4, s4 = t5[0] ? Z(t5[0]).harness : 0, o4 = s4 && s4.aliases;
        if (!o4) return e4;
        for (i4 in r4 = ct({}, e4), o4) if (i4 in r4) for (n3 = (a4 = o4[i4].split(",")).length; n3--; ) r4[a4[n3]] = r4[i4];
        return r4;
      })(f2, e3)), l3 = f2.length; l3--; ) if (~d2.indexOf(f2[l3])) for (u2 in a3 = p2[l3], "all" === e3 ? (i3[l3] = e3, o3 = a3, s3 = {}) : (s3 = i3[l3] = i3[l3] || {}, o3 = e3), o3) (h3 = a3 && a3[u2]) && ("kill" in h3.d && true !== h3.d.kill(u2) || pa(this, h3, "_pt"), delete a3[u2]), "all" !== s3 && (s3[u2] = 1);
      return this._initted && !this._pt && c2 && fb(this), this;
    }, Tween.to = function to(t4, e3, r3) {
      return new Tween(t4, e3, r3);
    }, Tween.from = function from(t4, e3) {
      return new Tween(t4, ca(arguments, 1));
    }, Tween.delayedCall = function delayedCall(t4, e3, r3, i3) {
      return new Tween(e3, 0, { immediateRender: false, lazy: false, overwrite: false, delay: t4, onComplete: e3, onReverseComplete: e3, onCompleteParams: r3, onReverseCompleteParams: r3, callbackScope: i3 });
    }, Tween.fromTo = function fromTo(t4, e3, r3) {
      return new Tween(t4, ca(arguments, 2));
    }, Tween.set = function set(t4, e3) {
      return e3.duration = 0, e3.repeatDelay || (e3.repeat = 0), new Tween(t4, e3);
    }, Tween.killTweensOf = function killTweensOf(t4, e3, r3) {
      return I.killTweensOf(t4, e3, r3);
    }, Tween;
  })(It);
  ha(Xt.prototype, { _targets: [], _lazy: 0, _startAt: 0, _op: 0, _onInit: 0 }), _("staggerTo,staggerFrom,staggerFromTo", function(r3) {
    Xt[r3] = function() {
      var t3 = new Rt(), e3 = vt.call(arguments, 0);
      return e3.splice("staggerFromTo" === r3 ? 5 : 4, 0, 0), t3[r3].apply(t3, e3);
    };
  });
  function Xb(t3, e3, r3) {
    return t3.setAttribute(e3, r3);
  }
  function dc(t3, e3, r3, i3) {
    i3.mSet(t3, e3, i3.m.call(i3.tween, r3, i3.mt), i3);
  }
  var Zt = function _setterPlain(t3, e3, r3) {
    return t3[e3] = r3;
  }, Vt = function _setterFunc(t3, e3, r3) {
    return t3[e3](r3);
  }, jt = function _setterFuncWithParam(t3, e3, r3, i3) {
    return t3[e3](i3.fp, r3);
  }, Gt = function _getSetter(t3, e3) {
    return o2(t3[e3]) ? Vt : q(t3[e3]) && t3.setAttribute ? Xb : Zt;
  }, Qt = function _renderPlain(t3, e3) {
    return e3.set(e3.t, e3.p, Math.round(1e4 * (e3.s + e3.c * t3)) / 1e4, e3);
  }, Jt = function _renderBoolean(t3, e3) {
    return e3.set(e3.t, e3.p, !!(e3.s + e3.c * t3), e3);
  }, Wt = function _renderComplexString(t3, e3) {
    var r3 = e3._pt, i3 = "";
    if (!t3 && e3.b) i3 = e3.b;
    else if (1 === t3 && e3.e) i3 = e3.e;
    else {
      for (; r3; ) i3 = r3.p + (r3.m ? r3.m(r3.s + r3.c * t3) : Math.round(1e4 * (r3.s + r3.c * t3)) / 1e4) + i3, r3 = r3._next;
      i3 += e3.c;
    }
    e3.set(e3.t, e3.p, i3, e3);
  }, $t = function _renderPropTweens(t3, e3) {
    for (var r3 = e3._pt; r3; ) r3.r(t3, r3.d), r3 = r3._next;
  }, Ht = function _addPluginModifier(t3, e3, r3, i3) {
    for (var n3, a3 = this._pt; a3; ) n3 = a3._next, a3.p === i3 && a3.modifier(t3, e3, r3), a3 = n3;
  }, Kt = function _killPropTweensOf(t3) {
    for (var e3, r3, i3 = this._pt; i3; ) r3 = i3._next, i3.p === t3 && !i3.op || i3.op === t3 ? pa(this, i3, "_pt") : i3.dep || (e3 = 1), i3 = r3;
    return !e3;
  }, te = function _sortPropTweensByPriority(t3) {
    for (var e3, r3, i3, n3, a3 = t3._pt; a3; ) {
      for (e3 = a3._next, r3 = i3; r3 && r3.pr > a3.pr; ) r3 = r3._next;
      (a3._prev = r3 ? r3._prev : n3) ? a3._prev._next = a3 : i3 = a3, (a3._next = r3) ? r3._prev = a3 : n3 = a3, a3 = e3;
    }
    t3._pt = i3;
  }, ee = (PropTween.prototype.modifier = function modifier(t3, e3, r3) {
    this.mSet = this.mSet || this.set, this.set = dc, this.m = t3, this.mt = r3, this.tween = e3;
  }, PropTween);
  function PropTween(t3, e3, r3, i3, n3, a3, s3, o3, u2) {
    this.t = e3, this.s = i3, this.c = n3, this.p = r3, this.r = a3 || Qt, this.d = s3 || this, this.set = o3 || Zt, this.pr = u2 || 0, (this._next = t3) && (t3._prev = this);
  }
  _(pt + "parent,duration,ease,delay,overwrite,runBackwards,startAt,yoyo,immediateRender,repeat,repeatDelay,data,paused,reversed,lazy,callbackScope,stringFilter,id,yoyoEase,stagger,inherit,repeatRefresh,keyframes,autoRevert,scrollTrigger", function(t3) {
    return st[t3] = 1;
  }), at.TweenMax = at.TweenLite = Xt, at.TimelineLite = at.TimelineMax = Rt, I = new Rt({ sortChildren: false, defaults: R, autoRemoveChildren: true, id: "root", smoothChildTiming: true }), U.stringFilter = qb;
  var re = { registerPlugin: function registerPlugin() {
    for (var t3 = arguments.length, e3 = new Array(t3), r3 = 0; r3 < t3; r3++) e3[r3] = arguments[r3];
    e3.forEach(function(t4) {
      return (function _createPlugin(t5) {
        var e4 = (t5 = !t5.name && t5.default || t5).name, r4 = o2(t5), i3 = e4 && !r4 && t5.init ? function() {
          this._props = [];
        } : t5, n3 = { init: O, render: $t, add: Bt, kill: Kt, modifier: Ht, rawVars: 0 }, a3 = { targetTest: 0, get: 0, getSetter: Gt, aliases: {}, register: 0 };
        if (Ct(), t5 !== i3) {
          if (ht[e4]) return;
          ha(i3, ha(la(t5, n3), a3)), ct(i3.prototype, ct(n3, la(t5, a3))), ht[i3.prop = e4] = i3, t5.targetTest && (dt.push(i3), st[e4] = 1), e4 = ("css" === e4 ? "CSS" : e4.charAt(0).toUpperCase() + e4.substr(1)) + "Plugin";
        }
        N(e4, i3), t5.register && t5.register(ie, i3, ee);
      })(t4);
    });
  }, timeline: function timeline(t3) {
    return new Rt(t3);
  }, getTweensOf: function getTweensOf(t3, e3) {
    return I.getTweensOf(t3, e3);
  }, getProperty: function getProperty(i3, t3, e3, r3) {
    n2(i3) && (i3 = yt(i3)[0]);
    var a3 = Z(i3 || {}).get, s3 = e3 ? ga : fa;
    return "native" === e3 && (e3 = ""), i3 ? t3 ? s3((ht[t3] && ht[t3].get || a3)(i3, t3, e3, r3)) : function(t4, e4, r4) {
      return s3((ht[t4] && ht[t4].get || a3)(i3, t4, e4, r4));
    } : i3;
  }, quickSetter: function quickSetter(r3, e3, i3) {
    if (1 < (r3 = yt(r3)).length) {
      var n3 = r3.map(function(t3) {
        return ie.quickSetter(t3, e3, i3);
      }), a3 = n3.length;
      return function(t3) {
        for (var e4 = a3; e4--; ) n3[e4](t3);
      };
    }
    r3 = r3[0] || {};
    var s3 = ht[e3], o3 = Z(r3), u2 = o3.harness && (o3.harness.aliases || {})[e3] || e3, h3 = s3 ? function(t3) {
      var e4 = new s3();
      c._pt = 0, e4.init(r3, i3 ? t3 + i3 : t3, c, 0, [r3]), e4.render(1, e4), c._pt && $t(1, c);
    } : o3.set(r3, u2);
    return s3 ? h3 : function(t3) {
      return h3(r3, u2, i3 ? t3 + i3 : t3, o3, 1);
    };
  }, isTweening: function isTweening(t3) {
    return 0 < I.getTweensOf(t3, true).length;
  }, defaults: function defaults(t3) {
    return t3 && t3.ease && (t3.ease = Ft(t3.ease, R.ease)), ka(R, t3 || {});
  }, config: function config(t3) {
    return ka(U, t3 || {});
  }, registerEffect: function registerEffect(t3) {
    var n3 = t3.name, i3 = t3.effect, e3 = t3.plugins, a3 = t3.defaults, s3 = t3.extendTimeline;
    (e3 || "").split(",").forEach(function(t4) {
      return t4 && !ht[t4] && !at[t4] && M(n3 + " effect requires " + t4 + " plugin.");
    }), lt[n3] = function(t4, e4, r3) {
      return i3(yt(t4), ha(e4 || {}, a3), r3);
    }, s3 && (Rt.prototype[n3] = function(t4, e4, i4) {
      return this.add(lt[n3](t4, r2(e4) ? e4 : (i4 = e4) && {}, this), i4);
    });
  }, registerEase: function registerEase(t3, e3) {
    At[t3] = Ft(e3);
  }, parseEase: function parseEase(t3, e3) {
    return arguments.length ? Ft(t3, e3) : At;
  }, getById: function getById(t3) {
    return I.getById(t3);
  }, exportRoot: function exportRoot(t3, e3) {
    void 0 === t3 && (t3 = {});
    var r3, i3, n3 = new Rt(t3);
    for (n3.smoothChildTiming = s2(t3.smoothChildTiming), I.remove(n3), n3._dp = 0, n3._time = n3._tTime = I._time, r3 = I._first; r3; ) i3 = r3._next, !e3 && !r3._dur && r3 instanceof Xt && r3.vars.onComplete === r3._targets[0] || Aa(n3, r3, r3._start - r3._delay), r3 = i3;
    return Aa(I, n3, 0), n3;
  }, utils: { wrap: function wrap(e3, t3, r3) {
    var i3 = t3 - e3;
    return J(e3) ? Za(e3, wrap(0, e3.length), t3) : Ja(r3, function(t4) {
      return (i3 + (t4 - e3) % i3) % i3 + e3;
    });
  }, wrapYoyo: function wrapYoyo(e3, t3, r3) {
    var i3 = t3 - e3, n3 = 2 * i3;
    return J(e3) ? Za(e3, wrapYoyo(0, e3.length - 1), t3) : Ja(r3, function(t4) {
      return e3 + (i3 < (t4 = (n3 + (t4 - e3) % n3) % n3 || 0) ? n3 - t4 : t4);
    });
  }, distribute: Sa, random: Va, snap: Ua, normalize: function normalize(t3, e3, r3) {
    return Tt(t3, e3, 0, 1, r3);
  }, getUnit: La, clamp: function clamp(e3, r3, t3) {
    return Ja(t3, function(t4) {
      return gt(e3, r3, t4);
    });
  }, splitColor: lb, toArray: yt, mapRange: Tt, pipe: function pipe() {
    for (var t3 = arguments.length, e3 = new Array(t3), r3 = 0; r3 < t3; r3++) e3[r3] = arguments[r3];
    return function(t4) {
      return e3.reduce(function(t5, e4) {
        return e4(t5);
      }, t4);
    };
  }, unitize: function unitize(e3, r3) {
    return function(t3) {
      return e3(parseFloat(t3)) + (r3 || La(t3));
    };
  }, interpolate: function interpolate(e3, r3, t3, i3) {
    var a3 = isNaN(e3 + r3) ? 0 : function(t4) {
      return (1 - t4) * e3 + t4 * r3;
    };
    if (!a3) {
      var s3, o3, u2, h3, l3, f2 = n2(e3), d2 = {};
      if (true === t3 && (i3 = 1) && (t3 = null), f2) e3 = { p: e3 }, r3 = { p: r3 };
      else if (J(e3) && !J(r3)) {
        for (u2 = [], h3 = e3.length, l3 = h3 - 2, o3 = 1; o3 < h3; o3++) u2.push(interpolate(e3[o3 - 1], e3[o3]));
        h3--, a3 = function func(t4) {
          t4 *= h3;
          var e4 = Math.min(l3, ~~t4);
          return u2[e4](t4 - e4);
        }, t3 = r3;
      } else i3 || (e3 = ct(J(e3) ? [] : {}, e3));
      if (!u2) {
        for (s3 in r3) Bt.call(d2, e3, s3, "get", r3[s3]);
        a3 = function func(t4) {
          return $t(t4, d2) || (f2 ? e3.p : e3);
        };
      }
    }
    return Ja(t3, a3);
  }, shuffle: Ra }, install: K, effects: lt, ticker: Mt, updateRoot: Rt.updateRoot, plugins: ht, globalTimeline: I, core: { PropTween: ee, globals: N, Tween: Xt, Timeline: Rt, Animation: It, getCache: Z, _removeLinkedListItem: pa } };
  _("to,from,fromTo,delayedCall,set,killTweensOf", function(t3) {
    return re[t3] = Xt[t3];
  }), Mt.add(Rt.updateRoot), c = re.to({}, { duration: 0 });
  function hc(t3, e3) {
    for (var r3 = t3._pt; r3 && r3.p !== e3 && r3.op !== e3 && r3.fp !== e3; ) r3 = r3._next;
    return r3;
  }
  function jc(t3, a3) {
    return { name: t3, rawVars: 1, init: function init2(t4, i3, e3) {
      e3._onInit = function(t5) {
        var e4, r3;
        if (n2(i3) && (e4 = {}, _(i3, function(t6) {
          return e4[t6] = 1;
        }), i3 = e4), a3) {
          for (r3 in e4 = {}, i3) e4[r3] = a3(i3[r3]);
          i3 = e4;
        }
        !(function _addModifiers(t6, e5) {
          var r4, i4, n3, a4 = t6._targets;
          for (r4 in e5) for (i4 = a4.length; i4--; ) (n3 = (n3 = t6._ptLookup[i4][r4]) && n3.d) && (n3._pt && (n3 = hc(n3, r4)), n3 && n3.modifier && n3.modifier(e5[r4], t6, a4[i4], r4));
        })(t5, i3);
      };
    } };
  }
  var ie = re.registerPlugin({ name: "attr", init: function init2(t3, e3, r3, i3, n3) {
    var a3, s3;
    for (a3 in e3) (s3 = this.add(t3, "setAttribute", (t3.getAttribute(a3) || 0) + "", e3[a3], i3, n3, 0, 0, a3)) && (s3.op = a3), this._props.push(a3);
  } }, { name: "endArray", init: function init2(t3, e3) {
    for (var r3 = e3.length; r3--; ) this.add(t3, r3, t3[r3] || 0, e3[r3]);
  } }, jc("roundProps", Ta), jc("modifiers"), jc("snap", Ua)) || re;
  Xt.version = Rt.version = ie.version = "3.4.2", f = 1, t2() && Ct();
  function Uc(t3, e3) {
    return e3.set(e3.t, e3.p, Math.round(1e4 * (e3.s + e3.c * t3)) / 1e4 + e3.u, e3);
  }
  function Vc(t3, e3) {
    return e3.set(e3.t, e3.p, 1 === t3 ? e3.e : Math.round(1e4 * (e3.s + e3.c * t3)) / 1e4 + e3.u, e3);
  }
  function Wc(t3, e3) {
    return e3.set(e3.t, e3.p, t3 ? Math.round(1e4 * (e3.s + e3.c * t3)) / 1e4 + e3.u : e3.b, e3);
  }
  function Xc(t3, e3) {
    var r3 = e3.s + e3.c * t3;
    e3.set(e3.t, e3.p, ~~(r3 + (r3 < 0 ? -0.5 : 0.5)) + e3.u, e3);
  }
  function Yc(t3, e3) {
    return e3.set(e3.t, e3.p, t3 ? e3.e : e3.b, e3);
  }
  function Zc(t3, e3) {
    return e3.set(e3.t, e3.p, 1 !== t3 ? e3.b : e3.e, e3);
  }
  function $c(t3, e3, r3) {
    return t3.style[e3] = r3;
  }
  function _c(t3, e3, r3) {
    return t3.style.setProperty(e3, r3);
  }
  function ad(t3, e3, r3) {
    return t3._gsap[e3] = r3;
  }
  function bd(t3, e3, r3) {
    return t3._gsap.scaleX = t3._gsap.scaleY = r3;
  }
  function cd(t3, e3, r3, i3, n3) {
    var a3 = t3._gsap;
    a3.scaleX = a3.scaleY = r3, a3.renderTransform(n3, a3);
  }
  function dd(t3, e3, r3, i3, n3) {
    var a3 = t3._gsap;
    a3[e3] = r3, a3.renderTransform(n3, a3);
  }
  function hd(t3, e3) {
    var r3 = ae.createElementNS ? ae.createElementNS((e3 || "http://www.w3.org/1999/xhtml").replace(/^https/, "http"), t3) : ae.createElement(t3);
    return r3.style ? r3 : ae.createElement(t3);
  }
  function id(t3, e3, r3) {
    var i3 = getComputedStyle(t3);
    return i3[e3] || i3.getPropertyValue(e3.replace(Ee, "-$1").toLowerCase()) || i3.getPropertyValue(e3) || !r3 && id(t3, Ne(e3) || e3, 1) || "";
  }
  function ld() {
    /* @__PURE__ */ (function _windowExists() {
      return "undefined" != typeof window;
    })() && window.document && (ne = window, ae = ne.document, se = ae.documentElement, ue = hd("div") || { style: {} }, he = hd("div"), Be = Ne(Be), qe = Be + "Origin", ue.style.cssText = "border-width:0;line-height:0;position:absolute;padding:0", fe = !!Ne("perspective"), oe = 1);
  }
  function md(t3) {
    var e3, r3 = hd("svg", this.ownerSVGElement && this.ownerSVGElement.getAttribute("xmlns") || "http://www.w3.org/2000/svg"), i3 = this.parentNode, n3 = this.nextSibling, a3 = this.style.cssText;
    if (se.appendChild(r3), r3.appendChild(this), this.style.display = "block", t3) try {
      e3 = this.getBBox(), this._gsapBBox = this.getBBox, this.getBBox = md;
    } catch (t4) {
    }
    else this._gsapBBox && (e3 = this._gsapBBox());
    return i3 && (n3 ? i3.insertBefore(this, n3) : i3.appendChild(this)), se.removeChild(r3), this.style.cssText = a3, e3;
  }
  function nd(t3, e3) {
    for (var r3 = e3.length; r3--; ) if (t3.hasAttribute(e3[r3])) return t3.getAttribute(e3[r3]);
  }
  function od(e3) {
    var r3;
    try {
      r3 = e3.getBBox();
    } catch (t3) {
      r3 = md.call(e3, true);
    }
    return r3 && (r3.width || r3.height) || e3.getBBox === md || (r3 = md.call(e3, true)), !r3 || r3.width || r3.x || r3.y ? r3 : { x: +nd(e3, ["x", "cx", "x1"]) || 0, y: +nd(e3, ["y", "cy", "y1"]) || 0, width: 0, height: 0 };
  }
  function pd(t3) {
    return !(!t3.getCTM || t3.parentNode && !t3.ownerSVGElement || !od(t3));
  }
  function qd(t3, e3) {
    if (e3) {
      var r3 = t3.style;
      e3 in Se && e3 !== qe && (e3 = Be), r3.removeProperty ? ("ms" !== e3.substr(0, 2) && "webkit" !== e3.substr(0, 6) || (e3 = "-" + e3), r3.removeProperty(e3.replace(Ee, "-$1").toLowerCase())) : r3.removeAttribute(e3);
    }
  }
  function rd(t3, e3, r3, i3, n3, a3) {
    var s3 = new ee(t3._pt, e3, r3, 0, 1, a3 ? Zc : Yc);
    return (t3._pt = s3).b = i3, s3.e = n3, t3._props.push(r3), s3;
  }
  function td(t3, e3, r3, i3) {
    var n3, a3, s3, o3, u2 = parseFloat(r3) || 0, h3 = (r3 + "").trim().substr((u2 + "").length) || "px", l3 = ue.style, f2 = Ie.test(e3), d2 = "svg" === t3.tagName.toLowerCase(), p2 = (d2 ? "client" : "offset") + (f2 ? "Width" : "Height"), c2 = "px" === i3, _2 = "%" === i3;
    return i3 === h3 || !u2 || Ue[i3] || Ue[h3] ? u2 : ("px" === h3 || c2 || (u2 = td(t3, e3, r3, "px")), o3 = t3.getCTM && pd(t3), _2 && (Se[e3] || ~e3.indexOf("adius")) ? aa(u2 / (o3 ? t3.getBBox()[f2 ? "width" : "height"] : t3[p2]) * 100) : (l3[f2 ? "width" : "height"] = 100 + (c2 ? h3 : i3), a3 = ~e3.indexOf("adius") || "em" === i3 && t3.appendChild && !d2 ? t3 : t3.parentNode, o3 && (a3 = (t3.ownerSVGElement || {}).parentNode), a3 && a3 !== ae && a3.appendChild || (a3 = ae.body), (s3 = a3._gsap) && _2 && s3.width && f2 && s3.time === Mt.time ? aa(u2 / s3.width * 100) : (!_2 && "%" !== h3 || (l3.position = id(t3, "position")), a3 === t3 && (l3.position = "static"), a3.appendChild(ue), n3 = ue[p2], a3.removeChild(ue), l3.position = "absolute", f2 && _2 && ((s3 = Z(a3)).time = Mt.time, s3.width = a3[p2]), aa(c2 ? n3 * u2 / 100 : n3 && u2 ? 100 / n3 * u2 : 0))));
  }
  function ud(t3, e3, r3, i3) {
    var n3;
    return oe || ld(), e3 in Le && "transform" !== e3 && ~(e3 = Le[e3]).indexOf(",") && (e3 = e3.split(",")[0]), Se[e3] && "transform" !== e3 ? (n3 = Ge(t3, i3), n3 = "transformOrigin" !== e3 ? n3[e3] : Qe(id(t3, qe)) + " " + n3.zOrigin + "px") : (n3 = t3.style[e3]) && "auto" !== n3 && !i3 && !~(n3 + "").indexOf("calc(") || (n3 = Ze[e3] && Ze[e3](t3, e3, r3) || id(t3, e3) || $(t3, e3) || ("opacity" === e3 ? 1 : 0)), r3 && !~(n3 + "").indexOf(" ") ? td(t3, e3, n3, r3) + r3 : n3;
  }
  function vd(t3, e3, r3, i3) {
    if (!r3 || "none" === r3) {
      var n3 = Ne(e3, t3, 1), a3 = n3 && id(t3, n3, 1);
      a3 && a3 !== r3 ? (e3 = n3, r3 = a3) : "borderColor" === e3 && (r3 = id(t3, "borderTopColor"));
    }
    var s3, o3, u2, h3, l3, f2, d2, p2, c2, _2, m2, g2, v2 = new ee(this._pt, t3.style, e3, 0, 1, Wt), y2 = 0, T2 = 0;
    if (v2.b = r3, v2.e = i3, r3 += "", "auto" === (i3 += "") && (t3.style[e3] = i3, i3 = id(t3, e3) || i3, t3.style[e3] = r3), qb(s3 = [r3, i3]), i3 = s3[1], u2 = (r3 = s3[0]).match(tt) || [], (i3.match(tt) || []).length) {
      for (; o3 = tt.exec(i3); ) d2 = o3[0], c2 = i3.substring(y2, o3.index), l3 ? l3 = (l3 + 1) % 5 : "rgba(" !== c2.substr(-5) && "hsla(" !== c2.substr(-5) || (l3 = 1), d2 !== (f2 = u2[T2++] || "") && (h3 = parseFloat(f2) || 0, m2 = f2.substr((h3 + "").length), (g2 = "=" === d2.charAt(1) ? +(d2.charAt(0) + "1") : 0) && (d2 = d2.substr(2)), p2 = parseFloat(d2), _2 = d2.substr((p2 + "").length), y2 = tt.lastIndex - _2.length, _2 || (_2 = _2 || U.units[e3] || m2, y2 === i3.length && (i3 += _2, v2.e += _2)), m2 !== _2 && (h3 = td(t3, e3, f2, _2) || 0), v2._pt = { _next: v2._pt, p: c2 || 1 === T2 ? c2 : ",", s: h3, c: g2 ? g2 * p2 : p2 - h3, m: l3 && l3 < 4 ? Math.round : 0 });
      v2.c = y2 < i3.length ? i3.substring(y2, i3.length) : "";
    } else v2.r = "display" === e3 && "none" === i3 ? Zc : Yc;
    return it.test(i3) && (v2.e = 0), this._pt = v2;
  }
  function xd(t3) {
    var e3 = t3.split(" "), r3 = e3[0], i3 = e3[1] || "50%";
    return "top" !== r3 && "bottom" !== r3 && "left" !== i3 && "right" !== i3 || (t3 = r3, r3 = i3, i3 = t3), e3[0] = Xe[r3] || r3, e3[1] = Xe[i3] || i3, e3.join(" ");
  }
  function yd(t3, e3) {
    if (e3.tween && e3.tween._time === e3.tween._dur) {
      var r3, i3, n3, a3 = e3.t, s3 = a3.style, o3 = e3.u, u2 = a3._gsap;
      if ("all" === o3 || true === o3) s3.cssText = "", i3 = 1;
      else for (n3 = (o3 = o3.split(",")).length; -1 < --n3; ) r3 = o3[n3], Se[r3] && (i3 = 1, r3 = "transformOrigin" === r3 ? qe : Be), qd(a3, r3);
      i3 && (qd(a3, Be), u2 && (u2.svg && a3.removeAttribute("transform"), Ge(a3, 1), u2.uncache = 1));
    }
  }
  function Cd(t3) {
    return "matrix(1, 0, 0, 1, 0, 0)" === t3 || "none" === t3 || !t3;
  }
  function Dd(t3) {
    var e3 = id(t3, Be);
    return Cd(e3) ? Ve : e3.substr(7).match(H).map(aa);
  }
  function Ed(t3, e3) {
    var r3, i3, n3, a3, s3 = t3._gsap || Z(t3), o3 = t3.style, u2 = Dd(t3);
    return s3.svg && t3.getAttribute("transform") ? "1,0,0,1,0,0" === (u2 = [(n3 = t3.transform.baseVal.consolidate().matrix).a, n3.b, n3.c, n3.d, n3.e, n3.f]).join(",") ? Ve : u2 : (u2 !== Ve || t3.offsetParent || t3 === se || s3.svg || (n3 = o3.display, o3.display = "block", (r3 = t3.parentNode) && t3.offsetParent || (a3 = 1, i3 = t3.nextSibling, se.appendChild(t3)), u2 = Dd(t3), n3 ? o3.display = n3 : qd(t3, "display"), a3 && (i3 ? r3.insertBefore(t3, i3) : r3 ? r3.appendChild(t3) : se.removeChild(t3))), e3 && 6 < u2.length ? [u2[0], u2[1], u2[4], u2[5], u2[12], u2[13]] : u2);
  }
  function Fd(t3, e3, r3, i3, n3, a3) {
    var s3, o3, u2, h3 = t3._gsap, l3 = n3 || Ed(t3, true), f2 = h3.xOrigin || 0, d2 = h3.yOrigin || 0, p2 = h3.xOffset || 0, c2 = h3.yOffset || 0, _2 = l3[0], m2 = l3[1], g2 = l3[2], v2 = l3[3], y2 = l3[4], T2 = l3[5], b2 = e3.split(" "), w2 = parseFloat(b2[0]) || 0, x2 = parseFloat(b2[1]) || 0;
    r3 ? l3 !== Ve && (o3 = _2 * v2 - m2 * g2) && (u2 = w2 * (-m2 / o3) + x2 * (_2 / o3) - (_2 * T2 - m2 * y2) / o3, w2 = w2 * (v2 / o3) + x2 * (-g2 / o3) + (g2 * T2 - v2 * y2) / o3, x2 = u2) : (w2 = (s3 = od(t3)).x + (~b2[0].indexOf("%") ? w2 / 100 * s3.width : w2), x2 = s3.y + (~(b2[1] || b2[0]).indexOf("%") ? x2 / 100 * s3.height : x2)), i3 || false !== i3 && h3.smooth ? (y2 = w2 - f2, T2 = x2 - d2, h3.xOffset = p2 + (y2 * _2 + T2 * g2) - y2, h3.yOffset = c2 + (y2 * m2 + T2 * v2) - T2) : h3.xOffset = h3.yOffset = 0, h3.xOrigin = w2, h3.yOrigin = x2, h3.smooth = !!i3, h3.origin = e3, h3.originIsAbsolute = !!r3, t3.style[qe] = "0px 0px", a3 && (rd(a3, h3, "xOrigin", f2, w2), rd(a3, h3, "yOrigin", d2, x2), rd(a3, h3, "xOffset", p2, h3.xOffset), rd(a3, h3, "yOffset", c2, h3.yOffset)), t3.setAttribute("data-svg-origin", w2 + " " + x2);
  }
  function Id(t3, e3, r3) {
    var i3 = La(e3);
    return aa(parseFloat(e3) + parseFloat(td(t3, "x", r3 + "px", i3))) + i3;
  }
  function Pd(t3, e3, r3, i3, a3, s3) {
    var o3, u2, h3 = 360, l3 = n2(a3), f2 = parseFloat(a3) * (l3 && ~a3.indexOf("rad") ? De : 1), d2 = s3 ? f2 * s3 : f2 - i3, p2 = i3 + d2 + "deg";
    return l3 && ("short" === (o3 = a3.split("_")[1]) && (d2 %= h3) !== d2 % 180 && (d2 += d2 < 0 ? h3 : -h3), "cw" === o3 && d2 < 0 ? d2 = (d2 + 36e9) % h3 - ~~(d2 / h3) * h3 : "ccw" === o3 && 0 < d2 && (d2 = (d2 - 36e9) % h3 - ~~(d2 / h3) * h3)), t3._pt = u2 = new ee(t3._pt, e3, r3, i3, d2, Vc), u2.e = p2, u2.u = "deg", t3._props.push(r3), u2;
  }
  function Qd(t3, e3, r3) {
    var i3, n3, a3, s3, o3, u2, h3, l3 = he.style, f2 = r3._gsap;
    for (n3 in l3.cssText = getComputedStyle(r3).cssText + ";position:absolute;display:block;", l3[Be] = e3, ae.body.appendChild(he), i3 = Ge(he, 1), Se) (a3 = f2[n3]) !== (s3 = i3[n3]) && "perspective,force3D,transformOrigin,svgOrigin".indexOf(n3) < 0 && (o3 = La(a3) !== (h3 = La(s3)) ? td(r3, n3, a3, h3) : parseFloat(a3), u2 = parseFloat(s3), t3._pt = new ee(t3._pt, f2, n3, o3, u2 - o3, Uc), t3._pt.u = h3 || 0, t3._props.push(n3));
    ae.body.removeChild(he);
  }
  var ne, ae, se, oe, ue, he, le, fe, de = At.Power0, pe = At.Power1, ce = At.Power2, _e = At.Power3, me = At.Power4, ge = At.Linear, ve = At.Quad, ye = At.Cubic, Te = At.Quart, be = At.Quint, we = At.Strong, xe = At.Elastic, ke = At.Back, Oe = At.SteppedEase, Me = At.Bounce, Ce = At.Sine, Ae = At.Expo, Pe = At.Circ, Se = {}, De = 180 / Math.PI, Fe = Math.PI / 180, ze = Math.atan2, Ee = /([A-Z])/g, Ie = /(?:left|right|width|margin|padding|x)/i, Re = /[\s,\(]\S/, Le = { autoAlpha: "opacity,visibility", scale: "scaleX,scaleY", alpha: "opacity" }, Be = "transform", qe = Be + "Origin", Ye = "O,Moz,ms,Ms,Webkit".split(","), Ne = function _checkPropPrefix(t3, e3, r3) {
    var i3 = (e3 || ue).style, n3 = 5;
    if (t3 in i3 && !r3) return t3;
    for (t3 = t3.charAt(0).toUpperCase() + t3.substr(1); n3-- && !(Ye[n3] + t3 in i3); ) ;
    return n3 < 0 ? null : (3 === n3 ? "ms" : 0 <= n3 ? Ye[n3] : "") + t3;
  }, Ue = { deg: 1, rad: 1, turn: 1 }, Xe = { top: "0%", bottom: "100%", left: "0%", right: "100%", center: "50%" }, Ze = { clearProps: function clearProps(t3, e3, r3, i3, n3) {
    if ("isFromStart" !== n3.data) {
      var a3 = t3._pt = new ee(t3._pt, e3, r3, 0, 0, yd);
      return a3.u = i3, a3.pr = -10, a3.tween = n3, t3._props.push(r3), 1;
    }
  } }, Ve = [1, 0, 0, 1, 0, 0], je = {}, Ge = function _parseTransform(t3, e3) {
    var r3 = t3._gsap || new Et(t3);
    if ("x" in r3 && !e3 && !r3.uncache) return r3;
    var i3, n3, a3, s3, o3, u2, h3, l3, f2, d2, p2, c2, _2, m2, g2, v2, y2, T2, b2, w2, x2, k2, O2, M2, C2, A2, P2, S2, D2, F2, z2, E2, I2 = t3.style, R2 = r3.scaleX < 0, L2 = "deg", B2 = id(t3, qe) || "0";
    return i3 = n3 = a3 = u2 = h3 = l3 = f2 = d2 = p2 = 0, s3 = o3 = 1, r3.svg = !(!t3.getCTM || !pd(t3)), m2 = Ed(t3, r3.svg), r3.svg && (M2 = !r3.uncache && t3.getAttribute("data-svg-origin"), Fd(t3, M2 || B2, !!M2 || r3.originIsAbsolute, false !== r3.smooth, m2)), c2 = r3.xOrigin || 0, _2 = r3.yOrigin || 0, m2 !== Ve && (T2 = m2[0], b2 = m2[1], w2 = m2[2], x2 = m2[3], i3 = k2 = m2[4], n3 = O2 = m2[5], 6 === m2.length ? (s3 = Math.sqrt(T2 * T2 + b2 * b2), o3 = Math.sqrt(x2 * x2 + w2 * w2), u2 = T2 || b2 ? ze(b2, T2) * De : 0, (f2 = w2 || x2 ? ze(w2, x2) * De + u2 : 0) && (o3 *= Math.cos(f2 * Fe)), r3.svg && (i3 -= c2 - (c2 * T2 + _2 * w2), n3 -= _2 - (c2 * b2 + _2 * x2))) : (E2 = m2[6], F2 = m2[7], P2 = m2[8], S2 = m2[9], D2 = m2[10], z2 = m2[11], i3 = m2[12], n3 = m2[13], a3 = m2[14], h3 = (g2 = ze(E2, D2)) * De, g2 && (M2 = k2 * (v2 = Math.cos(-g2)) + P2 * (y2 = Math.sin(-g2)), C2 = O2 * v2 + S2 * y2, A2 = E2 * v2 + D2 * y2, P2 = k2 * -y2 + P2 * v2, S2 = O2 * -y2 + S2 * v2, D2 = E2 * -y2 + D2 * v2, z2 = F2 * -y2 + z2 * v2, k2 = M2, O2 = C2, E2 = A2), l3 = (g2 = ze(-w2, D2)) * De, g2 && (v2 = Math.cos(-g2), z2 = x2 * (y2 = Math.sin(-g2)) + z2 * v2, T2 = M2 = T2 * v2 - P2 * y2, b2 = C2 = b2 * v2 - S2 * y2, w2 = A2 = w2 * v2 - D2 * y2), u2 = (g2 = ze(b2, T2)) * De, g2 && (M2 = T2 * (v2 = Math.cos(g2)) + b2 * (y2 = Math.sin(g2)), C2 = k2 * v2 + O2 * y2, b2 = b2 * v2 - T2 * y2, O2 = O2 * v2 - k2 * y2, T2 = M2, k2 = C2), h3 && 359.9 < Math.abs(h3) + Math.abs(u2) && (h3 = u2 = 0, l3 = 180 - l3), s3 = aa(Math.sqrt(T2 * T2 + b2 * b2 + w2 * w2)), o3 = aa(Math.sqrt(O2 * O2 + E2 * E2)), g2 = ze(k2, O2), f2 = 2e-4 < Math.abs(g2) ? g2 * De : 0, p2 = z2 ? 1 / (z2 < 0 ? -z2 : z2) : 0), r3.svg && (M2 = t3.getAttribute("transform"), r3.forceCSS = t3.setAttribute("transform", "") || !Cd(id(t3, Be)), M2 && t3.setAttribute("transform", M2))), 90 < Math.abs(f2) && Math.abs(f2) < 270 && (R2 ? (s3 *= -1, f2 += u2 <= 0 ? 180 : -180, u2 += u2 <= 0 ? 180 : -180) : (o3 *= -1, f2 += f2 <= 0 ? 180 : -180)), r3.x = ((r3.xPercent = i3 && Math.round(t3.offsetWidth / 2) === Math.round(-i3) ? -50 : 0) ? 0 : i3) + "px", r3.y = ((r3.yPercent = n3 && Math.round(t3.offsetHeight / 2) === Math.round(-n3) ? -50 : 0) ? 0 : n3) + "px", r3.z = a3 + "px", r3.scaleX = aa(s3), r3.scaleY = aa(o3), r3.rotation = aa(u2) + L2, r3.rotationX = aa(h3) + L2, r3.rotationY = aa(l3) + L2, r3.skewX = f2 + L2, r3.skewY = d2 + L2, r3.transformPerspective = p2 + "px", (r3.zOrigin = parseFloat(B2.split(" ")[2]) || 0) && (I2[qe] = Qe(B2)), r3.xOffset = r3.yOffset = 0, r3.force3D = U.force3D, r3.renderTransform = r3.svg ? tr : fe ? Ke : Je, r3.uncache = 0, r3;
  }, Qe = function _firstTwoOnly(t3) {
    return (t3 = t3.split(" "))[0] + " " + t3[1];
  }, Je = function _renderNon3DTransforms(t3, e3) {
    e3.z = "0px", e3.rotationY = e3.rotationX = "0deg", e3.force3D = 0, Ke(t3, e3);
  }, We = "0deg", $e = "0px", He = ") ", Ke = function _renderCSSTransforms(t3, e3) {
    var r3 = e3 || this, i3 = r3.xPercent, n3 = r3.yPercent, a3 = r3.x, s3 = r3.y, o3 = r3.z, u2 = r3.rotation, h3 = r3.rotationY, l3 = r3.rotationX, f2 = r3.skewX, d2 = r3.skewY, p2 = r3.scaleX, c2 = r3.scaleY, _2 = r3.transformPerspective, m2 = r3.force3D, g2 = r3.target, v2 = r3.zOrigin, y2 = "", T2 = "auto" === m2 && t3 && 1 !== t3 || true === m2;
    if (v2 && (l3 !== We || h3 !== We)) {
      var b2, w2 = parseFloat(h3) * Fe, x2 = Math.sin(w2), k2 = Math.cos(w2);
      w2 = parseFloat(l3) * Fe, b2 = Math.cos(w2), a3 = Id(g2, a3, x2 * b2 * -v2), s3 = Id(g2, s3, -Math.sin(w2) * -v2), o3 = Id(g2, o3, k2 * b2 * -v2 + v2);
    }
    _2 !== $e && (y2 += "perspective(" + _2 + He), (i3 || n3) && (y2 += "translate(" + i3 + "%, " + n3 + "%) "), !T2 && a3 === $e && s3 === $e && o3 === $e || (y2 += o3 !== $e || T2 ? "translate3d(" + a3 + ", " + s3 + ", " + o3 + ") " : "translate(" + a3 + ", " + s3 + He), u2 !== We && (y2 += "rotate(" + u2 + He), h3 !== We && (y2 += "rotateY(" + h3 + He), l3 !== We && (y2 += "rotateX(" + l3 + He), f2 === We && d2 === We || (y2 += "skew(" + f2 + ", " + d2 + He), 1 === p2 && 1 === c2 || (y2 += "scale(" + p2 + ", " + c2 + He), g2.style[Be] = y2 || "translate(0, 0)";
  }, tr = function _renderSVGTransforms(t3, e3) {
    var r3, i3, n3, a3, s3, o3 = e3 || this, u2 = o3.xPercent, h3 = o3.yPercent, l3 = o3.x, f2 = o3.y, d2 = o3.rotation, p2 = o3.skewX, c2 = o3.skewY, _2 = o3.scaleX, m2 = o3.scaleY, g2 = o3.target, v2 = o3.xOrigin, y2 = o3.yOrigin, T2 = o3.xOffset, b2 = o3.yOffset, w2 = o3.forceCSS, x2 = parseFloat(l3), k2 = parseFloat(f2);
    d2 = parseFloat(d2), p2 = parseFloat(p2), (c2 = parseFloat(c2)) && (p2 += c2 = parseFloat(c2), d2 += c2), d2 || p2 ? (d2 *= Fe, p2 *= Fe, r3 = Math.cos(d2) * _2, i3 = Math.sin(d2) * _2, n3 = Math.sin(d2 - p2) * -m2, a3 = Math.cos(d2 - p2) * m2, p2 && (c2 *= Fe, s3 = Math.tan(p2 - c2), n3 *= s3 = Math.sqrt(1 + s3 * s3), a3 *= s3, c2 && (s3 = Math.tan(c2), r3 *= s3 = Math.sqrt(1 + s3 * s3), i3 *= s3)), r3 = aa(r3), i3 = aa(i3), n3 = aa(n3), a3 = aa(a3)) : (r3 = _2, a3 = m2, i3 = n3 = 0), (x2 && !~(l3 + "").indexOf("px") || k2 && !~(f2 + "").indexOf("px")) && (x2 = td(g2, "x", l3, "px"), k2 = td(g2, "y", f2, "px")), (v2 || y2 || T2 || b2) && (x2 = aa(x2 + v2 - (v2 * r3 + y2 * n3) + T2), k2 = aa(k2 + y2 - (v2 * i3 + y2 * a3) + b2)), (u2 || h3) && (s3 = g2.getBBox(), x2 = aa(x2 + u2 / 100 * s3.width), k2 = aa(k2 + h3 / 100 * s3.height)), s3 = "matrix(" + r3 + "," + i3 + "," + n3 + "," + a3 + "," + x2 + "," + k2 + ")", g2.setAttribute("transform", s3), w2 && (g2.style[Be] = s3);
  };
  _("padding,margin,Width,Radius", function(e3, r3) {
    var t3 = "Right", i3 = "Bottom", n3 = "Left", o3 = (r3 < 3 ? ["Top", t3, i3, n3] : ["Top" + n3, "Top" + t3, i3 + t3, i3 + n3]).map(function(t4) {
      return r3 < 2 ? e3 + t4 : "border" + t4 + e3;
    });
    Ze[1 < r3 ? "border" + e3 : e3] = function(e4, t4, r4, i4, n4) {
      var a3, s3;
      if (arguments.length < 4) return a3 = o3.map(function(t5) {
        return ud(e4, t5, r4);
      }), 5 === (s3 = a3.join(" ")).split(a3[0]).length ? a3[0] : s3;
      a3 = (i4 + "").split(" "), s3 = {}, o3.forEach(function(t5, e5) {
        return s3[t5] = a3[e5] = a3[e5] || a3[(e5 - 1) / 2 | 0];
      }), e4.init(t4, s3, n4);
    };
  });
  var er, rr, ir, nr = { name: "css", register: ld, targetTest: function targetTest(t3) {
    return t3.style && t3.nodeType;
  }, init: function init2(t3, e3, r3, i3, n3) {
    var a3, s3, o3, u2, h3, l3, f2, d2, p2, c2, _2, m2, g2, v2, y2, T2 = this._props, b2 = t3.style;
    for (f2 in oe || ld(), e3) if ("autoRound" !== f2 && (s3 = e3[f2], !ht[f2] || !Mb(f2, e3, r3, i3, t3, n3))) if (h3 = typeof s3, l3 = Ze[f2], "function" === h3 && (h3 = typeof (s3 = s3.call(r3, i3, t3, n3))), "string" === h3 && ~s3.indexOf("random(") && (s3 = ab(s3)), l3) l3(this, t3, f2, s3, r3) && (y2 = 1);
    else if ("--" === f2.substr(0, 2)) this.add(b2, "setProperty", getComputedStyle(t3).getPropertyValue(f2) + "", s3 + "", i3, n3, 0, 0, f2);
    else {
      if (a3 = ud(t3, f2), u2 = parseFloat(a3), (c2 = "string" === h3 && "=" === s3.charAt(1) ? +(s3.charAt(0) + "1") : 0) && (s3 = s3.substr(2)), o3 = parseFloat(s3), f2 in Le && ("autoAlpha" === f2 && (1 === u2 && "hidden" === ud(t3, "visibility") && o3 && (u2 = 0), rd(this, b2, "visibility", u2 ? "inherit" : "hidden", o3 ? "inherit" : "hidden", !o3)), "scale" !== f2 && "transform" !== f2 && ~(f2 = Le[f2]).indexOf(",") && (f2 = f2.split(",")[0])), _2 = f2 in Se) if (m2 || ((g2 = t3._gsap).renderTransform || Ge(t3), v2 = false !== e3.smoothOrigin && g2.smooth, (m2 = this._pt = new ee(this._pt, b2, Be, 0, 1, g2.renderTransform, g2, 0, -1)).dep = 1), "scale" === f2) this._pt = new ee(this._pt, g2, "scaleY", g2.scaleY, c2 ? c2 * o3 : o3 - g2.scaleY), T2.push("scaleY", f2), f2 += "X";
      else {
        if ("transformOrigin" === f2) {
          s3 = xd(s3), g2.svg ? Fd(t3, s3, 0, v2, 0, this) : ((p2 = parseFloat(s3.split(" ")[2]) || 0) !== g2.zOrigin && rd(this, g2, "zOrigin", g2.zOrigin, p2), rd(this, b2, f2, Qe(a3), Qe(s3)));
          continue;
        }
        if ("svgOrigin" === f2) {
          Fd(t3, s3, 1, v2, 0, this);
          continue;
        }
        if (f2 in je) {
          Pd(this, g2, f2, u2, s3, c2);
          continue;
        }
        if ("smoothOrigin" === f2) {
          rd(this, g2, "smooth", g2.smooth, s3);
          continue;
        }
        if ("force3D" === f2) {
          g2[f2] = s3;
          continue;
        }
        if ("transform" === f2) {
          Qd(this, s3, t3);
          continue;
        }
      }
      else f2 in b2 || (f2 = Ne(f2) || f2);
      if (_2 || (o3 || 0 === o3) && (u2 || 0 === u2) && !Re.test(s3) && f2 in b2) (d2 = (a3 + "").substr((u2 + "").length)) !== (p2 = (s3 + "").substr(((o3 = o3 || 0) + "").length) || (f2 in U.units ? U.units[f2] : d2)) && (u2 = td(t3, f2, a3, p2)), this._pt = new ee(this._pt, _2 ? g2 : b2, f2, u2, c2 ? c2 * o3 : o3 - u2, "px" !== p2 || false === e3.autoRound || _2 ? Uc : Xc), this._pt.u = p2 || 0, d2 !== p2 && (this._pt.b = a3, this._pt.r = Wc);
      else if (f2 in b2) vd.call(this, t3, f2, a3, s3);
      else {
        if (!(f2 in t3)) {
          L(f2, s3);
          continue;
        }
        this.add(t3, f2, t3[f2], s3, i3, n3);
      }
      T2.push(f2);
    }
    y2 && te(this);
  }, get: ud, aliases: Le, getSetter: function getSetter(t3, e3, r3) {
    var i3 = Le[e3];
    return i3 && i3.indexOf(",") < 0 && (e3 = i3), e3 in Se && e3 !== qe && (t3._gsap.x || ud(t3, "x")) ? r3 && le === r3 ? "scale" === e3 ? bd : ad : (le = r3 || {}) && ("scale" === e3 ? cd : dd) : t3.style && !q(t3.style[e3]) ? $c : ~e3.indexOf("-") ? _c : Gt(t3, e3);
  }, core: { _removeProperty: qd, _getMatrix: Ed } };
  ie.utils.checkPrefix = Ne, ir = _((er = "x,y,z,scale,scaleX,scaleY,xPercent,yPercent") + "," + (rr = "rotation,rotationX,rotationY,skewX,skewY") + ",transform,transformOrigin,svgOrigin,force3D,smoothOrigin,transformPerspective", function(t3) {
    Se[t3] = 1;
  }), _(rr, function(t3) {
    U.units[t3] = "deg", je[t3] = 1;
  }), Le[ir[13]] = er + "," + rr, _("0:translateX,1:translateY,2:translateZ,8:rotate,8:rotationZ,8:rotateZ,9:rotateX,10:rotateY", function(t3) {
    var e3 = t3.split(":");
    Le[e3[1]] = ir[e3[0]];
  }), _("x,y,z,top,right,bottom,left,width,height,fontSize,padding,margin,perspective", function(t3) {
    U.units[t3] = "px";
  }), ie.registerPlugin(nr);
  var ar = ie.registerPlugin(nr) || ie, sr = ar.core.Tween;
  e2.Back = ke, e2.Bounce = Me, e2.CSSPlugin = nr, e2.Circ = Pe, e2.Cubic = ye, e2.Elastic = xe, e2.Expo = Ae, e2.Linear = ge, e2.Power0 = de, e2.Power1 = pe, e2.Power2 = ce, e2.Power3 = _e, e2.Power4 = me, e2.Quad = ve, e2.Quart = Te, e2.Quint = be, e2.Sine = Ce, e2.SteppedEase = Oe, e2.Strong = we, e2.TimelineLite = Rt, e2.TimelineMax = Rt, e2.TweenLite = Xt, e2.TweenMax = sr, e2.default = ar, e2.gsap = ar;
  if (typeof window === "undefined" || window !== e2) {
    Object.defineProperty(e2, "__esModule", { value: true });
  } else {
    delete e2.default;
  }
});
class Scroll {
  constructor(container) {
    this.engine = null;
    this.container = container;
    this.init();
  }
  init() {
    console.log(" ... init Smooth scrolling");
    this.engine = new Lenis({
      wrapper: window,
      content: document.querySelector("[data-scroll-content]"),
      orientation: "vertical",
      smoothWheel: true,
      smoothTouch: false,
      lerp: 0.5,
      duration: 1,
      normalizeWheel: true
    });
    this.engine.on("scroll", (e2) => this.onScroll(e2));
    const raf = (time) => {
      this.engine.raf(time);
      requestAnimationFrame(raf);
    };
    requestAnimationFrame(raf);
  }
  destroy() {
    if (this.engine) {
      this.engine.destroy();
      this.engine = null;
    }
  }
  stop() {
    if (this.engine) this.engine.stop();
  }
  start() {
    if (this.engine) this.engine.start();
  }
  resize() {
    if (this.engine) this.engine.dimensions.resize();
  }
  onScroll(e2) {
    const header = document.querySelector("[data-header]");
    const fab = document.querySelector("[fab]");
    if (!header) return;
    if (e2.direction === 1) {
      document.documentElement.setAttribute("data-scroll-direction", "down");
      if (e2.scroll > 100) {
        header.setAttribute("collapsed", "true");
        if (fab) fab.setAttribute("collapsed", "true");
      }
      if (e2.scroll > 200) {
        header.setAttribute("hide", "true");
        if (fab) fab.setAttribute("hide", "true");
      }
    } else if (e2.direction === -1) {
      document.documentElement.setAttribute("data-scroll-direction", "up");
      header.removeAttribute("hide");
      if (fab) fab.removeAttribute("hide");
      if (e2.scroll < 100) {
        header.removeAttribute("collapsed");
        if (fab) fab.removeAttribute("collapsed");
      }
    }
  }
  scrollTo(target, options = {}) {
    if (this.engine) this.engine.scrollTo(target, options);
  }
}
var SCROLL;
function initScroll() {
  window.SCROLL = new Scroll(document.querySelector("[data-scroll-container]"));
  SCROLL = window.SCROLL;
}
class Reveal {
  constructor(selector = "[data-scroll]") {
    this.selector = selector;
    this.progressEntries = [];
    this.observer = null;
    this.vh = window.innerHeight;
    this.init();
  }
  init() {
    this.observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        const el = entry.target;
        const shouldRepeat = el.hasAttribute("data-scroll-repeat");
        const ignore = el.hasAttribute("data-scroll-ignore");
        const isProgress = el.hasAttribute("data-scroll-progress");
        const hasText = el.matches("[data-reveal-text]") || el.querySelector("[data-reveal-text]");
        if (entry.isIntersecting) {
          if (hasText && !el.classList.contains("is-split")) {
            this._splitText(el);
          } else if (!ignore) {
            el.classList.add("is-inview");
          }
          if (!shouldRepeat && !isProgress && !hasText) {
            this.observer.unobserve(el);
          }
        } else {
          if (shouldRepeat) {
            el.classList.remove("is-inview");
          }
        }
      });
    }, {
      rootMargin: "0px 0px -50px 0px",
      threshold: 0.05
    });
    this.measureProgressElements();
    window.addEventListener("resize", () => {
      this.vh = window.innerHeight;
      this.measureProgressElements();
      this.updateProgress(window.SCROLL?.engine?.scroll ?? window.scrollY);
    }, { passive: true });
    if (window.SCROLL && window.SCROLL.engine) {
      window.SCROLL.engine.on("scroll", (e2) => {
        this.updateProgress(e2.scroll);
      });
    } else {
      window.addEventListener("scroll", () => {
        this.updateProgress(window.scrollY);
      }, { passive: true });
    }
  }
  measureProgressElements() {
    const scrollY = window.SCROLL?.engine?.scroll ?? window.scrollY ?? 0;
    this.progressEntries = Array.from(document.querySelectorAll("[data-scroll-progress]")).map((el) => {
      const rect = el.getBoundingClientRect();
      return {
        el,
        top: rect.top + scrollY,
        height: rect.height
      };
    });
  }
  // Direct synchronous calculation: ZERO DOM READS during scroll!
  updateProgress(scrollY) {
    if (!this.progressEntries || this.progressEntries.length === 0) return;
    const vh = this.vh;
    for (let i2 = 0; i2 < this.progressEntries.length; i2++) {
      const entry = this.progressEntries[i2];
      const currentTop = entry.top - scrollY;
      if (currentTop < vh + 150 && currentTop > -entry.height - 150) {
        const progress = Math.max(0, Math.min(1, (vh - currentTop) / (vh + entry.height)));
        entry.el.style.setProperty("--progress", progress.toFixed(3));
      }
    }
  }
  enable() {
    document.documentElement.classList.add("reveal-enabled");
    this.refresh();
    this.measureProgressElements();
    this.updateProgress(window.SCROLL?.engine?.scroll ?? window.scrollY ?? 0);
  }
  _splitText(parentEl) {
    const targets = parentEl.matches("[data-reveal-text]") ? [parentEl, ...parentEl.querySelectorAll("[data-reveal-text]")] : parentEl.querySelectorAll("[data-reveal-text]");
    targets.forEach((target) => {
      if (target.classList.contains("is-split")) return;
      const splitType = target.getAttribute("data-reveal-text") || "chars";
      if (typeof Splitting === "function") {
        Splitting({ target, by: splitType });
        target.querySelectorAll("[data-reveal-text]:not(.chars) [data-word]").forEach((item) => {
          item.innerHTML = `<span class="inner-wrap">${item.textContent}</span>`;
        });
      }
      target.classList.add("is-split");
    });
    requestAnimationFrame(() => {
      parentEl.classList.add("is-inview");
    });
  }
  initImages() {
    const checkImage = (img) => {
      if (img.complete && img.naturalWidth > 0) {
        img.classList.add("is-loaded");
      } else {
        img.addEventListener("load", () => img.classList.add("is-loaded"), { once: true });
        img.addEventListener("error", () => img.classList.add("is-loaded"), { once: true });
      }
    };
    document.querySelectorAll("figure img, img[loading]").forEach(checkImage);
  }
  refresh() {
    this.initImages();
    document.querySelectorAll(this.selector).forEach((el) => this.observer.observe(el));
  }
}
var REVEAL;
function initReveals() {
  console.log(" ... init Reveal animations");
  REVEAL = new Reveal();
  REVEAL.initImages();
}
class Collapsibles {
  constructor(el) {
    console.log(" ... init Collapsible widgets");
    this.DOM = {
      widget: el,
      items: el.querySelectorAll("collapsible")
    };
    this.active = null;
    this.unique = el.getAttribute("data-collapsibles") ? el.getAttribute("data-collapsibles") : false;
    this.init();
  }
  init() {
    this.DOM.items.forEach((el) => {
      el.querySelector("[collapsible-trigger]").addEventListener("click", (e2) => {
        this.active = el;
        this.toggle();
      });
    });
  }
  toggle() {
    this.active.toggleAttribute("open");
    this.unique ? this.closeSiblings() : null;
    setTimeout(() => {
      SCROLL.resize();
    }, 1e3);
  }
  closeSiblings() {
    this.DOM.items.forEach((el) => {
      if (el != this.active) {
        el.removeAttribute("open");
      }
    });
  }
}
function initCollapsibles() {
  var collapsibles = document.querySelectorAll("[data-collapsibles]");
  if (collapsibles) {
    collapsibles.forEach((el) => {
      new Collapsibles(el);
    });
  }
}
class Tabs {
  constructor(el) {
    if (!el) return;
    console.log("... init Tabs widgets");
    this.DOM = {
      widget: el,
      // Collect containers only if this specific widget is their immediate data-tabs parent
      containers: Array.from(el.querySelectorAll("[data-pane-container]")).filter((item) => item.closest("[data-tabs]") === el),
      tabs: Array.from(el.querySelectorAll("[data-tab], [data-async-tab]")).filter((item) => item.closest("[data-tabs]") === el),
      panes: Array.from(el.querySelectorAll("[data-pane]")).filter((item) => item.closest("[data-tabs]") === el),
      nav: {
        prev: Array.from(el.querySelectorAll("[data-tab-prev]")).filter((item) => item.closest("[data-tabs]") === el),
        next: Array.from(el.querySelectorAll("[data-tab-next]")).filter((item) => item.closest("[data-tabs]") === el)
      }
    };
    this.settings = {
      animationDuration: 1e3,
      debounceDuration: 0
    };
    this.data = {
      active: 0,
      next: 0,
      cache: {}
    };
    this.zIndexCounter = 100;
    this.is_changing = false;
    this.is_scrolling_via_click = false;
    this.scroll_timeout = null;
    this.hover_timeout = null;
    this.closing_timeouts = [];
    this.scrollTriggers = [];
    this.observer = null;
    this.is_hoverable = el.getAttribute("data-tabs") === "hoverable";
    this.is_scrollable = el.getAttribute("data-tabs") === "scrollable";
    this.is_noinit = el.getAttribute("data-tabs") === "noinit";
    this.is_fluid = el.hasAttribute("data-fluid");
    this._boundHandleKeydown = this.handleKeydown.bind(this);
    this._boundScrollEvent = this.handleScrollEvent.bind(this);
    this.autoplayInterval = parseInt(el.getAttribute("data-autoplay")) || 0;
    this.autoplayTimer = null;
    if (this.autoplayInterval > 0) this.startAutoplay();
    this.init();
  }
  init() {
    if (this.is_fluid) this.DOM.widget.classList.add("--fluid");
    const datasetTabsValue = this.DOM.widget.dataset.tabs;
    if (datasetTabsValue === "hoverable") {
      this.data.active = 0;
    } else if (datasetTabsValue && isNaN(datasetTabsValue)) {
      const parsedIndex = this.getTabIndexByPaneValue(datasetTabsValue);
      this.data.active = parsedIndex !== -1 ? parsedIndex : 0;
    } else {
      this.data.active = parseInt(datasetTabsValue) || 0;
    }
    this.setupA11y();
    this.initEvents();
    this.initScrollTriggers();
    this.updateZIndices(this.data.active);
    if (!this.is_noinit) this.setActive(this.data.active);
  }
  setupA11y() {
    const tabList = this.DOM.tabs[0]?.parentNode;
    if (tabList) tabList.setAttribute("role", "tablist");
    this.DOM.tabs.forEach((tab, i2) => {
      const paneValue = tab.dataset.tab || tab.dataset.asyncTab || i2;
      const tabId = `tab-${i2}`;
      tab.setAttribute("role", "tab");
      tab.setAttribute("id", tabId);
      tab.setAttribute("aria-controls", `pane-group-${paneValue}`);
      tab.setAttribute("tabindex", "-1");
    });
    this.DOM.panes.forEach((pane) => {
      const paneValue = pane.dataset.pane;
      if (!paneValue) return;
      const tabIndex = this.getTabIndexByPaneValue(paneValue);
      const tabId = tabIndex !== -1 ? `tab-${tabIndex}` : "";
      pane.setAttribute("role", "tabpanel");
      if (tabId) pane.setAttribute("aria-labelledby", tabId);
    });
  }
  initScrollTriggers() {
    const uniquePaneNames = [...new Set(this.DOM.panes.map((p) => p.dataset.pane).filter(Boolean))];
    uniquePaneNames.forEach((paneName) => {
      const trigger = document.querySelector(`[data-pane-trigger="${paneName}"]`);
      if (trigger) {
        this.scrollTriggers.push({ trigger, paneName });
      }
    });
    if (this.scrollTriggers.length === 0) return;
    const observerOptions = {
      root: null,
      rootMargin: "-20% 0px -79% 0px",
      threshold: 0
    };
    this.observer = new IntersectionObserver((entries) => {
      if (this.is_scrolling_via_click) return;
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const paneName = entry.target.dataset.paneTrigger;
          const index = this.getTabIndexByPaneValue(paneName);
          if (index !== -1 && index !== this.data.active) {
            this.setActive(index);
          }
        }
      });
    }, observerOptions);
    this.scrollTriggers.forEach((item) => this.observer.observe(item.trigger));
    this._boundUpdateProgress = this.updateScrollProgress.bind(this);
    window.addEventListener("scroll", this._boundUpdateProgress, { passive: true });
    this.updateScrollProgress();
  }
  updateScrollProgress() {
    if (this.scrollTriggers.length === 0) return;
    const firstTrigger = this.scrollTriggers[0].trigger;
    const lastTrigger = this.scrollTriggers[this.scrollTriggers.length - 1].trigger;
    const firstRect = firstTrigger.getBoundingClientRect();
    const lastRect = lastTrigger.getBoundingClientRect();
    const totalDistance = lastRect.top - firstRect.top + lastRect.height;
    if (totalDistance <= 0) {
      this.DOM.widget.style.setProperty("--progress", "0");
      return;
    }
    const currentScroll = -firstRect.top;
    let progress = currentScroll / totalDistance;
    progress = Math.max(0, Math.min(1, progress));
    this.DOM.widget.style.setProperty("--progress", progress.toFixed(3));
  }
  setActive(index, force = false) {
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
    if (index < 0 || index >= liveTabs.length) return;
    const tab = liveTabs[index];
    if (tab && tab.hasAttribute("data-async-tab")) {
      const url = tab.getAttribute("href");
      if (url && !this.data.cache[url]) {
        if (this.DOM.widget.classList.contains("--loading-async")) return;
        this.loadAsync(index, url);
        return;
      }
    }
    this.data.next = index;
    this.change(force);
  }
  setActivePane(paneName) {
    if (!paneName) return;
    const panes = Array.from(this.DOM.widget.querySelectorAll("[data-pane]")).filter((item) => item.closest("[data-tabs]") === this.DOM.widget);
    const targetPane = panes.find((p) => p.dataset.pane === paneName);
    if (!targetPane) return;
    this.activeCustomPane = paneName;
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]")).filter((tab) => tab.closest("[data-tabs]") === this.DOM.widget);
    liveTabs.forEach((tab) => {
      const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
      const isActive = tabValue === paneName;
      tab.toggleAttribute("data-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.setAttribute("tabindex", isActive ? "0" : "-1");
    });
    panes.forEach((p) => {
      const isNewPane = p === targetPane;
      if (isNewPane) {
        p.setAttribute("data-active", "true");
        p.classList.remove("is-closing");
      } else {
        p.removeAttribute("data-active");
      }
    });
    if (this.is_fluid) {
      this.updateFluidBounds(targetPane);
    }
  }
  change(force = false) {
    const isFirstInit = !this.DOM.widget.hasAttribute("data-init");
    if (this.data.active === this.data.next && !isFirstInit && !this.activeCustomPane && !force) return;
    this.activeCustomPane = null;
    this.DOM.widget.setAttribute("data-init", "true");
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]")).filter((tab) => tab.closest("[data-tabs]") === this.DOM.widget);
    const activeTab = liveTabs[this.data.next] || this.DOM.tabs[this.data.next];
    const activePaneValue = activeTab ? activeTab.dataset.tab || activeTab.dataset.asyncTab || String(this.data.next) : null;
    this.updateZIndices(activePaneValue);
    liveTabs.forEach((tab) => {
      const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
      const isActive = tabValue === activePaneValue;
      tab.toggleAttribute("data-active", isActive);
      tab.setAttribute("aria-selected", isActive ? "true" : "false");
      tab.setAttribute("tabindex", isActive ? "0" : "-1");
    });
    let targetActivePane = null;
    this.DOM.panes.forEach((p, i2) => {
      const isNewPane = p.dataset.pane ? p.dataset.pane === activePaneValue : i2 === this.data.next;
      if (isNewPane) {
        p.setAttribute("data-active", "true");
        p.classList.remove("is-closing");
        targetActivePane = p;
      } else {
        p.removeAttribute("data-active");
      }
    });
    if (this.is_fluid && targetActivePane) {
      this.updateFluidBounds(targetActivePane);
    }
    this.data.active = this.data.next;
    this.onTabChange();
  }
  updateFluidBounds(activePane) {
    this.DOM.containers.forEach((container) => {
      const width = activePane.offsetWidth;
      const height = activePane.offsetHeight;
      container.style.width = `${width}px`;
      container.style.height = `${height}px`;
    });
  }
  updateZIndices(activePaneValue) {
    if (!this.is_hoverable) return;
    this.zIndexCounter++;
    this.DOM.panes.forEach((p) => {
      const isNew = p.dataset.pane === activePaneValue;
      if (isNew) p.style.zIndex = this.zIndexCounter + 100;
    });
  }
  async loadAsync(index, url) {
    if (this.data.cache[url]) {
      this.injectAsyncContent(index, this.data.cache[url]);
      this.data.next = index;
      this.change();
      return;
    }
    this.DOM.widget.classList.add("--loading-async");
    try {
      const response = await fetch(url);
      const json = await response.json();
      this.data.cache[url] = json.html;
      this.injectAsyncContent(index, json.html);
      this.data.next = index;
      this.change();
      const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
      liveTabs[index]?.focus();
    } catch (err) {
      console.error("Async Tab Error:", err);
    } finally {
      this.DOM.widget.classList.remove("--loading-async");
    }
  }
  injectAsyncContent(index, html) {
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
    const tab = liveTabs[index];
    const paneValue = tab ? tab.dataset.tab || tab.dataset.asyncTab || index : index;
    this.DOM.panes.forEach((pane) => {
      if (pane.dataset.pane === paneValue) {
        const loader = pane.querySelector("[data-load]") || pane;
        loader.innerHTML = html;
      }
    });
  }
  handleKeydown(e2) {
    const targetTab = e2.target.closest("[data-tab], [data-async-tab]");
    if (!targetTab || !this.DOM.widget.contains(targetTab)) return;
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
    let index = liveTabs.indexOf(targetTab);
    const lastIndex = liveTabs.length - 1;
    switch (e2.key) {
      case "ArrowRight":
        index = index === lastIndex ? 0 : index + 1;
        break;
      case "ArrowLeft":
        index = index === 0 ? lastIndex : index - 1;
        break;
      case "Home":
        index = 0;
        break;
      case "End":
        index = lastIndex;
        break;
      default:
        return;
    }
    e2.preventDefault();
    this.setActive(index);
    if (!liveTabs[index].hasAttribute("data-async-tab") || this.data.cache[liveTabs[index].getAttribute("href")]) {
      liveTabs[index].focus();
    }
  }
  handleScrollEvent(e2) {
    const { target, way } = e2.detail;
    if (way === "enter") {
      const index = this.DOM.panes.indexOf(target);
      if (index !== -1) this.setActive(index);
    }
  }
  scrollToTrigger(index) {
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
    const tab = liveTabs[index];
    const paneName = tab ? tab.dataset.tab || tab.dataset.asyncTab : null;
    const trigger = this.scrollTriggers.find((t2) => t2.paneName === paneName)?.trigger;
    if (trigger) {
      this.is_scrolling_via_click = true;
      clearTimeout(this.scroll_timeout);
      const y = trigger.getBoundingClientRect().top + window.pageYOffset;
      if (window.SCROLL) window.SCROLL.scrollTo(y);
      this.scroll_timeout = setTimeout(() => {
        this.is_scrolling_via_click = false;
      }, this.settings.animationDuration);
    }
  }
  getTabIndexByPaneValue(paneValue) {
    const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]")).filter((tab) => tab.closest("[data-tabs]") === this.DOM.widget);
    return liveTabs.findIndex((tab) => {
      return tab.dataset.tab === paneValue || tab.dataset.asyncTab === paneValue;
    });
  }
  startAutoplay() {
    console.log("Start autoplay ...");
    this.autoplayTimer = setInterval(() => {
      const nextIndex = this.data.active < this.DOM.tabs.length - 1 ? this.data.active + 1 : 0;
      this.setActive(nextIndex);
    }, this.autoplayInterval);
  }
  resetAutoplay() {
    if (this.autoplayTimer) {
      clearInterval(this.autoplayTimer);
      this.startAutoplay();
    }
  }
  destroy() {
    this.DOM.widget.removeEventListener("keydown", this._boundHandleKeydown);
    window.removeEventListener("scrollTabEvent", this._boundScrollEvent);
    if (this._boundUpdateProgress) {
      window.removeEventListener("scroll", this._boundUpdateProgress);
    }
    if (this.observer) this.observer.disconnect();
    clearTimeout(this.scroll_timeout);
    clearTimeout(this.hover_timeout);
    this.closing_timeouts.forEach((id) => clearTimeout(id));
    this.DOM.panes.forEach((p) => p.style.zIndex = "");
    this.DOM.widget.removeAttribute("data-scroll-progress");
    this.DOM.widget.style.removeProperty("--progress");
  }
  initEvents() {
    if (this.is_hoverable) {
      const setupHoverListeners = () => {
        const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
        liveTabs.forEach((tab) => {
          const getIndex = () => {
            const value = tab.dataset.tab || tab.dataset.asyncTab;
            return !value ? liveTabs.indexOf(tab) : this.getTabIndexByPaneValue(value);
          };
          const handleHover = () => {
            const index = getIndex();
            if (index === -1) return;
            const currentTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
            currentTabs.forEach((t2, i2) => {
              const isActive = i2 === index;
              t2.toggleAttribute("data-active", isActive);
              t2.setAttribute("aria-selected", isActive ? "true" : "false");
              t2.setAttribute("tabindex", isActive ? "0" : "-1");
            });
            clearTimeout(this.hover_timeout);
            this.hover_timeout = setTimeout(() => {
              if (index !== this.data.active) this.setActive(index);
            }, this.settings.debounceDuration);
          };
          tab.addEventListener("mouseenter", handleHover);
          tab.addEventListener("mousemove", handleHover);
          tab.addEventListener("mouseleave", () => {
            clearTimeout(this.hover_timeout);
            const currentTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
            currentTabs.forEach((t2, i2) => {
              const isActive = i2 === this.data.active;
              t2.toggleAttribute("data-active", isActive);
              t2.setAttribute("aria-selected", isActive ? "true" : "false");
              t2.setAttribute("tabindex", isActive ? "0" : "-1");
            });
          });
        });
      };
      setupHoverListeners();
    }
    this.DOM.widget.addEventListener("click", (e2) => {
      const tab = e2.target.closest("[data-tab], [data-async-tab]");
      const clickedLink = e2.target.closest("a");
      if (tab && this.DOM.widget.contains(tab)) {
        const href = clickedLink?.getAttribute("href");
        if (href && href !== "#" && href !== "") return;
        if (!clickedLink && !tab.hasAttribute("href")) e2.preventDefault();
        const tabValue = tab.dataset.tab || tab.dataset.asyncTab;
        const index = tabValue ? this.getTabIndexByPaneValue(tabValue) : Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]")).indexOf(tab);
        if (index !== -1) {
          clearTimeout(this.hover_timeout);
          this.setActive(index);
          this.scrollToTrigger(index);
        }
        return;
      }
      const liveTabs = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"));
      if (e2.target.closest("[data-tab-prev]")) {
        clearTimeout(this.hover_timeout);
        const prevIndex = this.data.active > 0 ? this.data.active - 1 : liveTabs.length - 1;
        this.setActive(prevIndex);
        this.scrollToTrigger(prevIndex);
      } else if (e2.target.closest("[data-tab-next]")) {
        clearTimeout(this.hover_timeout);
        const nextIndex = this.data.active < liveTabs.length - 1 ? this.data.active + 1 : 0;
        this.setActive(nextIndex);
        this.scrollToTrigger(nextIndex);
      }
      if (tab && this.DOM.widget.contains(tab)) {
        this.resetAutoplay();
        return;
      }
      if (e2.target.closest("[data-tab-prev]")) {
        this.resetAutoplay();
      } else if (e2.target.closest("[data-tab-next]")) {
        this.resetAutoplay();
      }
    });
    this.DOM.widget.addEventListener("keydown", this._boundHandleKeydown);
    window.addEventListener("scrollTabEvent", this._boundScrollEvent);
    if (this.is_fluid) {
      window.addEventListener("resize", () => {
        const activeTab = Array.from(this.DOM.widget.querySelectorAll("[data-tab], [data-async-tab]"))[this.data.active];
        const activePaneValue = activeTab ? activeTab.dataset.tab || activeTab.dataset.asyncTab : null;
        const currentPane = this.DOM.panes.find((p) => p.dataset.pane === activePaneValue);
        if (currentPane) this.updateFluidBounds(currentPane);
      });
    }
  }
  onTabChange() {
    if (window.SCROLL) window.SCROLL.resize();
    const line = this.DOM.widget.querySelector("[data-tabs-autoplay-line]");
    if (line) {
      line.style.animation = "none";
      void line.offsetWidth;
      line.style.animation = null;
    }
  }
}
function initTabs() {
  document.querySelectorAll("[data-tabs]").forEach((el) => new Tabs(el));
}
document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".custom-dropdown");
  dropdowns.forEach((dropdown) => {
    const toggle = dropdown.querySelector(".dropdown-toggle");
    const menu = dropdown.querySelector(".dropdown-menu");
    const selectedText = dropdown.querySelector(".dropdown-selected-text");
    const items = dropdown.querySelectorAll(".dropdown-menu li");
    toggle.addEventListener("click", () => {
      const expanded = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", !expanded);
      menu.classList.toggle("is-open");
    });
    items.forEach((item) => {
      item.addEventListener("click", () => {
        selectedText.textContent = item.textContent;
        toggle.setAttribute("aria-expanded", "false");
        menu.classList.remove("is-open");
        const value = item.dataset.value;
        console.log("Selected value:", value);
      });
    });
    window.addEventListener("click", (e2) => {
      if (!dropdown.contains(e2.target)) {
        toggle.setAttribute("aria-expanded", "false");
        menu.classList.remove("is-open");
      }
    });
  });
});
class ProjectSearch {
  constructor(container) {
    this.container = container;
    this.form = container.querySelector("form");
    this.input = container.querySelector(".project-search__input");
    this.clearBtn = container.querySelector(".project-search__clear");
    this.dropdown = container.querySelector(".project-search__dropdown");
    this.list = container.querySelector("[data-search-list]");
    this.footer = container.querySelector("[data-search-footer]");
    this.apiUrl = container.dataset.apiUrl || "/api/projects/search";
    this.debounceTimer = null;
    this.cache = {};
    this.selectedIndex = -1;
    this.currentItems = [];
    this.isOpen = false;
    this.init();
  }
  init() {
    if (!this.input || !this.dropdown) return;
    this.input.addEventListener("input", () => {
      const query = this.input.value.trim();
      this.toggleClearBtn(query.length > 0);
      if (query.length < 1) {
        this.close();
        return;
      }
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.fetchResults(query);
      }, 180);
    });
    this.input.addEventListener("focus", () => {
      const query = this.input.value.trim();
      if (query.length >= 1) {
        if (this.cache[query]) {
          this.renderResults(this.cache[query], query);
          this.open();
        } else {
          this.fetchResults(query);
        }
      }
    });
    if (this.clearBtn) {
      this.clearBtn.addEventListener("click", (e2) => {
        e2.preventDefault();
        this.input.value = "";
        this.toggleClearBtn(false);
        this.close();
        this.input.focus();
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("search") || urlParams.has("q")) {
          this.form.submit();
        }
      });
    }
    this.input.addEventListener("keydown", (e2) => {
      if (!this.isOpen) return;
      const itemsCount = this.currentItems.length;
      if (e2.key === "ArrowDown") {
        e2.preventDefault();
        if (itemsCount > 0) {
          this.selectedIndex = (this.selectedIndex + 1) % itemsCount;
          this.updateSelection();
        }
      } else if (e2.key === "ArrowUp") {
        e2.preventDefault();
        if (itemsCount > 0) {
          this.selectedIndex = (this.selectedIndex - 1 + itemsCount) % itemsCount;
          this.updateSelection();
        }
      } else if (e2.key === "Enter") {
        if (this.selectedIndex >= 0 && this.currentItems[this.selectedIndex]) {
          e2.preventDefault();
          const selectedUrl = this.currentItems[this.selectedIndex].url;
          if (selectedUrl) {
            window.location.href = selectedUrl;
          }
        }
      } else if (e2.key === "Escape") {
        e2.preventDefault();
        this.close();
      }
    });
    document.addEventListener("click", (e2) => {
      if (!this.container.contains(e2.target)) {
        this.close();
      }
    });
  }
  toggleClearBtn(show) {
    if (this.clearBtn) {
      this.clearBtn.classList.toggle("is-visible", show);
    }
  }
  async fetchResults(query) {
    let searchUrl = `${this.apiUrl}?q=${encodeURIComponent(query)}`;
    const ind = this.form.querySelector('input[name="industry"]')?.value;
    const sp = this.form.querySelector('input[name="space"]')?.value;
    if (ind) searchUrl += `&industry=${encodeURIComponent(ind)}`;
    if (sp) searchUrl += `&space=${encodeURIComponent(sp)}`;
    const cacheKey = `${query}|${ind || ""}|${sp || ""}`;
    if (this.cache[cacheKey]) {
      this.renderResults(this.cache[cacheKey], query);
      this.open();
      return;
    }
    this.container.classList.add("is-loading");
    try {
      const res = await fetch(searchUrl);
      if (!res.ok) throw new Error("Network response failed");
      const data = await res.json();
      this.cache[cacheKey] = data;
      this.renderResults(data, query);
      this.open();
    } catch (err) {
      console.warn("Search error:", err);
    } finally {
      this.container.classList.remove("is-loading");
    }
  }
  renderResults(results, query) {
    this.currentItems = results || [];
    this.selectedIndex = -1;
    const noResultsText = this.container.dataset.i18nNoResults || "\u017D\xE1dn\xE9 projekty nenalezeny";
    const allResultsText = this.container.dataset.i18nAllResults || "Zobrazit v\u0161echny v\xFDsledky";
    if (!this.currentItems.length) {
      this.list.innerHTML = `
				<div class="project-search__empty">
					${this.escapeHtml(noResultsText)} pro \u201E<strong>${this.escapeHtml(query)}</strong>\u201C
				</div>
			`;
      if (this.footer) this.footer.innerHTML = "";
      return;
    }
    const html = this.currentItems.map((item, index) => {
      const highlightedTitle = this.highlightMatch(item.title, query);
      const metaParts = [item.industry, item.space, item.location, item.year].filter(Boolean);
      const metaString = metaParts.join(" \xB7 ");
      return `
				<a href="${this.escapeHtml(item.url)}" class="project-search__item" role="option" data-index="${index}">
					<div class="project-search__thumb">
						${item.cover ? `<img src="${this.escapeHtml(item.cover)}" alt="${this.escapeHtml(item.title)}" loading="lazy">` : `<div class="project-search__thumb-placeholder">U1</div>`}
					</div>
					<div class="project-search__info">
						<span class="project-search__title">${highlightedTitle}</span>
						${metaString ? `<span class="project-search__meta">${this.escapeHtml(metaString)}</span>` : ""}
					</div>
				</a>
			`;
    }).join("");
    this.list.innerHTML = html;
    if (this.footer) {
      this.footer.innerHTML = `
				<button type="submit" onclick="this.closest('.project-search').querySelector('form').submit();">
					<span>${this.escapeHtml(allResultsText)} pro \u201E${this.escapeHtml(query)}\u201C</span>
					<span>&rarr;</span>
				</button>
			`;
    }
    this.list.querySelectorAll(".project-search__item").forEach((itemEl, idx) => {
      itemEl.addEventListener("mouseenter", () => {
        this.selectedIndex = idx;
        this.updateSelection();
      });
    });
  }
  updateSelection() {
    const items = this.list.querySelectorAll(".project-search__item");
    items.forEach((item, idx) => {
      const isSelected = idx === this.selectedIndex;
      item.classList.toggle("is-selected", isSelected);
      item.setAttribute("aria-selected", isSelected ? "true" : "false");
      if (isSelected) {
        item.scrollIntoView({ block: "nearest" });
      }
    });
  }
  highlightMatch(text, query) {
    if (!text || !query) return this.escapeHtml(text || "");
    const escaped = this.escapeHtml(text);
    const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    const regex = new RegExp(`(${escapedQuery})`, "gi");
    return escaped.replace(regex, "<mark>$1</mark>");
  }
  escapeHtml(str) {
    return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
  }
  open() {
    this.dropdown.classList.add("is-open");
    this.input.setAttribute("aria-expanded", "true");
    this.isOpen = true;
  }
  close() {
    this.dropdown.classList.remove("is-open");
    this.input.setAttribute("aria-expanded", "false");
    this.selectedIndex = -1;
    this.isOpen = false;
  }
}
function initProjectSearch() {
  document.querySelectorAll("[data-project-search]").forEach((el) => {
    if (el._projectSearch) return;
    el._projectSearch = new ProjectSearch(el);
  });
}
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initProjectSearch);
} else {
  initProjectSearch();
}
class Loader {
  constructor(onProgress, onComplete) {
    console.log("Loading: 0%");
    this.images = Array.from(document.querySelectorAll("img"));
    this.total = this.images.length;
    this.loaded = 0;
    this.onProgress = onProgress || (() => {
    });
    this.onComplete = onComplete || (() => {
    });
  }
  // init() {
  //     if (this.total === 0) return this.onComplete();
  //     this.images.forEach(img => {
  //         // Check if image is already complete (cached)
  //         if (img.complete) {
  //             this.updateProgress();
  //         } else {
  //             img.addEventListener('load', () => this.updateProgress());
  //             img.addEventListener('error', () => this.updateProgress());
  //         }
  //     });
  // }
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
    const safetyTimeout = setTimeout(() => {
      if (this.loaded < this.total) {
        console.warn("Loader timed out waiting for images, proceeding.");
        completeOnce();
      }
    }, 3500);
    const checkDone = () => {
      if (this.loaded >= this.total) {
        clearTimeout(safetyTimeout);
        completeOnce();
      }
    };
    this.images.forEach((img) => {
      const rawSrc = img.getAttribute("src");
      if (!rawSrc || rawSrc.trim() === "" || img.src === window.location.href) {
        this.loaded++;
        checkDone();
        return;
      }
      const tempImage = new Image();
      tempImage.src = img.src;
      tempImage.onload = () => {
        const rect = img.getBoundingClientRect();
        const width = rect.width;
        const height = rect.height;
        img.width = width;
        img.height = height;
        img.style.setProperty("--w", `${width}px`);
        img.style.setProperty("--h", `${height}px`);
        this.updateProgress();
        checkDone();
      };
      tempImage.onerror = () => {
        console.warn(`Failed to load: ${img.src}`);
        this.updateProgress();
        checkDone();
      };
    });
  }
  updateProgress() {
    this.loaded++;
    const percent = Math.min(Math.floor(this.loaded / this.total * 100), 100);
    this.onProgress(percent);
  }
}
class Navbar {
  constructor(el) {
    if (!el) return;
    console.log(" ... init Navbar widget");
    this.DOM = {
      html: document.documentElement,
      navbar: el,
      widget: el.querySelector("[navbar-widget]"),
      triggers: document.querySelectorAll("[navbar-toggle]"),
      closeBtns: el.querySelectorAll("[navbar-close]")
    };
    this.state = { isOpen: false };
    this.handleDocumentClick = this.handleDocumentClick.bind(this);
    this.handleKeyDown = this.handleKeyDown.bind(this);
    this.init();
  }
  init() {
    this.DOM.triggers.forEach((btn) => btn.addEventListener("click", (e2) => this.toggle(e2)));
    this.DOM.closeBtns.forEach((btn) => btn.addEventListener("click", () => this.close()));
  }
  toggle(e2) {
    if (e2) {
      e2.preventDefault();
      e2.stopPropagation();
    }
    this.state.isOpen ? this.close() : this.open();
  }
  open() {
    if (this.state.isOpen) return;
    this.state.isOpen = true;
    this.DOM.html.style.overflow = "hidden";
    this.DOM.html.setAttribute("navbar-open", "true");
    this.DOM.navbar.setAttribute("aria-hidden", "false");
    document.addEventListener("click", this.handleDocumentClick);
    document.addEventListener("keydown", this.handleKeyDown);
  }
  close() {
    if (!this.state.isOpen) return;
    this.state.isOpen = false;
    this.DOM.html.style.overflow = "";
    this.DOM.html.removeAttribute("navbar-open");
    this.DOM.navbar.setAttribute("aria-hidden", "true");
    document.removeEventListener("click", this.handleDocumentClick);
    document.removeEventListener("keydown", this.handleKeyDown);
  }
  handleKeyDown(e2) {
    if (e2.key === "Escape") this.close();
  }
  handleDocumentClick(e2) {
    if (this.DOM.widget && !this.DOM.widget.contains(e2.target) && !e2.target.closest("[data-aside-toggle]")) {
      this.close();
    }
  }
}
function initNavbar() {
  document.querySelector("[navbar]") ? new Navbar(document.querySelector("[navbar]")) : null;
}
class Carousel {
  constructor(el) {
    if (!el) return;
    this.carousel = el;
    this.DOM = {
      navNext: Array.from(this.carousel.querySelectorAll("[data-carousel-next]")),
      navPrev: Array.from(this.carousel.querySelectorAll("[data-carousel-prev]")),
      // NOVÝ ELEMENT: Detektor dragování a klikání
      scrollArea: this.carousel.querySelector("[data-carousel-scroll]"),
      panes: this.carousel.querySelector("[data-carousel-slides]"),
      items: this.carousel.querySelector("[data-carousel-slides]") ? Array.from(this.carousel.querySelector("[data-carousel-slides]").querySelectorAll("[data-slide]")) : [],
      tabs: Array.from(this.carousel.querySelectorAll("[data-carousel-tab]"))
    };
    if (this.DOM.items.length === 0 || !this.DOM.scrollArea || !this.DOM.panes) return;
    this.active = 0;
    this.perPage = this.carousel.getAttribute("data-per-page") ? parseInt(this.carousel.getAttribute("data-per-page"), 10) : 1;
    this.dynamic = this.carousel.hasAttribute("dynamic");
    this.itemSizeWithGap = 0;
    this.maxScroll = 0;
    this.currentX = 0;
    this.isPressed = false;
    this.isDragged = false;
    this.touch = {
      start: 0,
      dragStartOffset: 0,
      distance: 0,
      lastX: 0,
      lastTime: 0,
      velocity: 0
    };
    this.config = {
      flickMinSpeed: 0.6,
      mediumSwipeRatio: 0.4,
      longSwipeRatio: 1.2,
      slowDragThreshold: 40,
      durationNormal: 0.45,
      durationMaxFlick: 0.75
    };
    this.init();
  }
  init() {
    console.log("... init Carousel widget with dedicated scroll area");
    this.resize();
    this.initEvents();
    window.requestAnimationFrame(() => this.resize());
    window.addEventListener("load", () => this.resize());
    this.change(this.active, 0);
  }
  resize() {
    if (!this.DOM.items.length) return;
    const firstItem = this.DOM.items[0];
    const lastItem = this.DOM.items[this.DOM.items.length - 1];
    const computedStyle = window.getComputedStyle(firstItem);
    const parentStyle = window.getComputedStyle(this.DOM.panes);
    const itemWidth = firstItem.offsetWidth;
    const marginRight = parseFloat(computedStyle.marginRight) || 0;
    const columnGap = parseFloat(parentStyle.columnGap) || parseFloat(parentStyle.gap) || 0;
    const gap = marginRight || columnGap;
    this.itemSizeWithGap = itemWidth + gap;
    const totalSlidesWidth = lastItem.offsetLeft + lastItem.offsetWidth - firstItem.offsetLeft;
    const visibleWidth = this.DOM.scrollArea.clientWidth;
    this.maxScroll = Math.max(0, totalSlidesWidth - visibleWidth);
    const maxIndex = this.itemSizeWithGap > 0 ? Math.ceil(this.maxScroll / this.itemSizeWithGap) : 0;
    if (this.active > maxIndex) {
      this.active = maxIndex;
    }
    this.change(this.active, 0);
  }
  initEvents() {
    window.addEventListener("resize", () => this.resize());
    this.DOM.navNext.forEach((el) => el.addEventListener("click", (e2) => this.next(e2)));
    this.DOM.navPrev.forEach((el) => el.addEventListener("click", (e2) => this.prev(e2)));
    this.DOM.tabs.forEach((tab, index) => {
      tab.addEventListener("click", (e2) => {
        e2.preventDefault();
        this.active = index;
        this.change(this.active);
      });
    });
    this.DOM.scrollArea.addEventListener("mousedown", (e2) => this.grab(e2));
    this.DOM.scrollArea.addEventListener("touchstart", (e2) => this.grab(e2), { passive: true });
    window.addEventListener("mousemove", (e2) => this.drag(e2));
    window.addEventListener("mouseup", (e2) => this.release(e2));
    window.addEventListener("touchmove", (e2) => this.drag(e2), { passive: false });
    window.addEventListener("touchend", (e2) => this.release(e2));
    this.DOM.scrollArea.addEventListener("click", (e2) => {
      if (this.isDragged) {
        e2.preventDefault();
        e2.stopPropagation();
      }
    }, true);
  }
  next(e2) {
    if (e2) e2.preventDefault();
    const maxIndex = this.itemSizeWithGap > 0 ? Math.ceil(this.maxScroll / this.itemSizeWithGap) : 0;
    if (this.currentX < this.maxScroll - 1 && this.active < maxIndex) {
      this.active++;
      this.change(this.active);
    } else if (this.currentX < this.maxScroll - 1) {
      this.change(maxIndex);
    } else {
      this.bounceBack();
    }
  }
  prev(e2) {
    if (e2) e2.preventDefault();
    if (this.currentX > 1 && this.active > 0) {
      this.active--;
      this.change(this.active);
    } else if (this.currentX > 1) {
      this.change(0);
    } else {
      this.bounceBack();
    }
  }
  change(index, duration = 0.6) {
    if (this.maxScroll <= 0) {
      this.currentX = 0;
      this.active = 0;
      gsap.to(this.DOM.panes, { x: 0, duration: 0.3, overwrite: "auto" });
      return;
    }
    const maxIndex = this.itemSizeWithGap > 0 ? Math.ceil(this.maxScroll / this.itemSizeWithGap) : 0;
    this.active = Math.max(0, Math.min(index, this.DOM.items.length - 1));
    let targetX = this.itemSizeWithGap * this.active;
    if (targetX >= this.maxScroll) {
      targetX = this.maxScroll;
    }
    this.currentX = targetX;
    gsap.to(this.DOM.panes, {
      x: -this.currentX,
      duration,
      ease: "power3.out",
      overwrite: "auto",
      onComplete: () => {
        this.DOM.panes.classList.remove("is-dragged");
        this.isDragged = false;
      }
    });
    this.DOM.items.forEach((el, i2) => {
      if (i2 === this.active) {
        el.setAttribute("data-active", "true");
      } else {
        el.removeAttribute("data-active");
      }
    });
    this.DOM.tabs.forEach((tab, i2) => {
      if (i2 === this.active) {
        tab.classList.add("is-active");
      } else {
        tab.classList.remove("is-active");
      }
    });
    if (this.dynamic && this.DOM.items[this.active]) {
      const newHeight = this.DOM.items[this.active].getBoundingClientRect().height;
      gsap.to(this.DOM.panes, { height: newHeight, duration: 0.3, ease: "power2.out" });
    }
    this.carousel.style.setProperty("--active", this.active);
  }
  grab(e2) {
    this.isPressed = true;
    const clientX = e2.touches ? e2.touches[0].clientX : e2.clientX;
    this.touch.start = clientX;
    this.touch.lastX = clientX;
    this.touch.dragStartOffset = this.currentX;
    this.touch.lastTime = performance.now();
    this.touch.velocity = 0;
    gsap.killTweensOf(this.DOM.panes);
  }
  drag(e2) {
    if (!this.isPressed) return;
    const currentClientX = e2.touches ? e2.touches[0].clientX : e2.clientX;
    this.touch.distance = currentClientX - this.touch.start;
    if (Math.abs(this.touch.distance) > 5) {
      this.isDragged = true;
      this.DOM.scrollArea.classList.add("is-dragged");
      this.DOM.panes.classList.add("is-dragged");
      let newX = this.touch.dragStartOffset - this.touch.distance;
      const now = performance.now();
      const elapsed = now - this.touch.lastTime;
      if (elapsed > 0) {
        const deltaX = currentClientX - this.touch.lastX;
        this.touch.velocity = deltaX / elapsed;
      }
      this.touch.lastX = currentClientX;
      this.touch.lastTime = now;
      if (newX < 0) {
        newX = newX * 0.25;
      } else if (newX > this.maxScroll) {
        newX = this.maxScroll + (newX - this.maxScroll) * 0.25;
      }
      gsap.set(this.DOM.panes, { x: -newX });
    }
  }
  release(e2) {
    if (!this.isPressed) return;
    this.isPressed = false;
    const maxIndex = this.itemSizeWithGap > 0 ? Math.ceil(this.maxScroll / this.itemSizeWithGap) : 0;
    if (this.isDragged) {
      const speed = Math.abs(this.touch.velocity);
      const distanceAbs = Math.abs(this.touch.distance);
      const mediumLimit = this.itemSizeWithGap * this.config.mediumSwipeRatio;
      const longLimit = this.itemSizeWithGap * this.config.longSwipeRatio;
      if (speed > this.config.flickMinSpeed) {
        const direction = Math.sign(this.touch.distance);
        if (distanceAbs > longLimit) {
          this.active = this.active - 3 * direction;
        } else if (distanceAbs > mediumLimit) {
          this.active = this.active - 2 * direction;
        } else {
          this.active = this.active - 1 * direction;
        }
        const dynamicDuration = Math.min(this.config.durationMaxFlick, Math.max(this.config.durationNormal, 1 / speed));
        this.change(this.active, dynamicDuration);
      } else {
        if (distanceAbs > this.config.slowDragThreshold) {
          const currentPhysicalX = this.touch.dragStartOffset - this.touch.distance;
          if (currentPhysicalX >= this.maxScroll - this.itemSizeWithGap * 0.35) {
            this.change(maxIndex, this.config.durationNormal);
          } else if (currentPhysicalX <= this.itemSizeWithGap * 0.35) {
            this.change(0, this.config.durationNormal);
          } else {
            let targetIndex = Math.round(currentPhysicalX / this.itemSizeWithGap);
            this.change(targetIndex, this.config.durationNormal);
          }
        } else {
          this.bounceBack();
        }
      }
      this.DOM.scrollArea.classList.remove("is-dragged");
      setTimeout(() => {
        this.isDragged = false;
      }, 100);
    } else {
      this.isDragged = false;
    }
    this.touch.distance = 0;
    this.touch.velocity = 0;
  }
  bounceBack() {
    this.change(this.active, this.config.durationNormal);
  }
}
function initCarousels() {
  document.querySelectorAll("[data-carousel]").forEach((el) => new Carousel(el));
}
class Contact {
  constructor(el) {
    if (!el) return;
    console.log(" ... init Contact widget");
    this.DOM = {
      html: document.documentElement,
      dialog: el.querySelector("[data-contact]"),
      widget: el.querySelector("[data-contact-widget]"),
      triggers: document.querySelectorAll("[data-contact-toggle]"),
      closeBtns: el.querySelectorAll("[data-contact-close]"),
      tabsWidget: el.querySelector("[data-tabs]")
    };
    this.state = {
      isOpen: false,
      isScrollPop: false
    };
    this.tabs = null;
    this.scrollObserver = null;
    this.handleDocumentClick = this.handleDocumentClick.bind(this);
    this.handleKeyDown = this.handleKeyDown.bind(this);
    this.init();
  }
  init() {
    if (this.DOM.tabsWidget && typeof Tabs === "function") {
      this.tabs = new Tabs(this.DOM.tabsWidget);
    }
    this.DOM.triggers.forEach((btn) => btn.addEventListener("click", (e2) => {
      if (e2) {
        e2.preventDefault();
        e2.stopPropagation();
      }
      const targetTab = btn.getAttribute("data-contact-toggle");
      if (this.state.isOpen) {
        if (this.state.isScrollPop) {
          this.upgradeToFullOpen(targetTab);
        } else if (targetTab && targetTab !== "true" && this.tabs) {
          const index = this.tabs.getTabIndexByPaneValue(targetTab);
          if (index !== -1) this.tabs.setActive(index);
        } else {
          this.close();
        }
      } else {
        this.open(targetTab, false);
      }
    }));
    this.DOM.closeBtns.forEach((btn) => btn.addEventListener("click", () => this.close()));
    this.initScrollTriggers();
    this.initForms();
  }
  initForms() {
    const forms = document.querySelectorAll('form[data-form="contact"], #contact-form, #career-form');
    forms.forEach((form) => {
      if (form._hasContactListener) return;
      form._hasContactListener = true;
      const formInputs = form.querySelectorAll("input, select, textarea");
      formInputs.forEach((input) => {
        input.addEventListener("input", () => {
          if (input.classList.contains("invalid")) {
            input.classList.remove("invalid");
            const errorBox = form.querySelector("[data-form-error]");
            if (errorBox && !form.querySelector(".invalid")) {
              errorBox.innerHTML = "";
            }
          }
        });
        input.addEventListener("change", () => {
          if (input.classList.contains("invalid")) {
            input.classList.remove("invalid");
          }
        });
      });
      form.addEventListener("submit", async (e2) => {
        e2.preventDefault();
        const submitBtn = form.querySelector('[data-form-submit], button[type="submit"]');
        const errorBox = form.querySelector("[data-form-error]");
        const successBox = form.querySelector("[data-form-success]");
        const inputs = form.querySelectorAll("input, select, textarea");
        if (errorBox) errorBox.innerHTML = "";
        if (successBox) successBox.classList.add("hidden");
        inputs.forEach((el) => el.classList.remove("invalid"));
        let hasClientError = false;
        const emailInput = form.querySelector('input[type="email"], input[name="email"]');
        const nameInput = form.querySelector('input[name="name"]');
        const msgInput = form.querySelector('textarea[name="message"]');
        if (nameInput && nameInput.value.trim().length < 2) {
          nameInput.classList.add("invalid");
          hasClientError = true;
        }
        if (emailInput && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
          emailInput.classList.add("invalid");
          hasClientError = true;
        }
        if (msgInput && msgInput.value.trim().length < 3) {
          msgInput.classList.add("invalid");
          hasClientError = true;
        }
        if (hasClientError) {
          if (errorBox) errorBox.innerHTML = "Pros\xEDm vypl\u0148te v\u0161echna povinn\xE1 pole.";
          const firstInvalid = form.querySelector(".invalid");
          if (firstInvalid) firstInvalid.focus();
          return;
        }
        const originalBtnText = submitBtn ? submitBtn.innerHTML : "Send";
        if (submitBtn) {
          submitBtn.innerHTML = "<span>Odes\xEDl\xE1m...</span>";
          submitBtn.setAttribute("disabled", "true");
        }
        try {
          const formData = new FormData(form);
          const actionUrl = form.getAttribute("action") || "/contact.json";
          const res = await fetch(actionUrl, {
            method: "POST",
            body: formData,
            headers: {
              "X-Requested-With": "XMLHttpRequest",
              "Accept": "application/json"
            }
          });
          const rawText = await res.text();
          let data = {};
          try {
            data = JSON.parse(rawText);
          } catch (parseErr) {
            console.error("Non-JSON response from server:", rawText);
            data = { status: "error", message: "Chyba serveru: " + rawText.substring(0, 100) };
          }
          if (res.ok && data.status === "success") {
            form.reset();
            if (errorBox) errorBox.innerHTML = "";
            if (this.tabs && typeof this.tabs.setActivePane === "function") {
              this.tabs.setActivePane("success");
            } else {
              const successPane = document.querySelector('[data-pane="success"]');
              const allPanes = document.querySelectorAll("[data-contact-widget] [data-pane]");
              allPanes.forEach((p) => p.removeAttribute("data-active"));
              if (successPane) successPane.setAttribute("data-active", "true");
            }
          } else {
            if (data.errors) {
              for (const [fieldName, err] of Object.entries(data.errors)) {
                const input = form.querySelector(`[name="${fieldName}"]`);
                if (input) input.classList.add("invalid");
              }
              const firstInvalid = form.querySelector(".invalid");
              if (firstInvalid) firstInvalid.focus();
            }
            if (errorBox) errorBox.innerHTML = data.message || "Chyba p\u0159i odes\xEDl\xE1n\xED formul\xE1\u0159e.";
          }
        } catch (err) {
          console.error("Contact Form Error:", err);
          if (errorBox) errorBox.innerHTML = "Nepoda\u0159ilo se odeslat zpr\xE1vu: " + (err.message || err);
        } finally {
          if (submitBtn) {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.removeAttribute("disabled");
          }
        }
      });
    });
  }
  initScrollTriggers() {
    const scrollElements = document.querySelectorAll("[data-contact-scroll-toggle]");
    if (scrollElements.length === 0) return;
    const observerOptions = {
      root: null,
      rootMargin: "0px",
      threshold: 0.2
    };
    this.scrollObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !this.state.isOpen) {
          const targetTab = entry.target.getAttribute("data-contact-scroll-toggle");
          this.open(targetTab === "true" ? null : targetTab, true);
          this.scrollObserver.unobserve(entry.target);
        }
      });
    }, observerOptions);
    scrollElements.forEach((el) => this.scrollObserver.observe(el));
  }
  open(targetTab, isScrollPop = false) {
    if (this.state.isOpen) return;
    this.state.isOpen = true;
    this.state.isScrollPop = isScrollPop;
    if (isScrollPop) {
      this.DOM.html.setAttribute("contact-open", "pop");
    } else {
      this.DOM.html.setAttribute("contact-open", "true");
      this.DOM.html.style.overflow = "hidden";
    }
    this.DOM.dialog.setAttribute("aria-hidden", "false");
    if (this.tabs) {
      if (targetTab && targetTab !== "true") {
        const index = this.tabs.getTabIndexByPaneValue(targetTab);
        if (index !== -1) {
          this.tabs.setActive(index, true);
        } else {
          this.tabs.setActive(0, true);
        }
      } else {
        this.tabs.setActive(0, true);
      }
    }
    if (this.tabs && this.tabs.is_fluid) {
      const activeTab = this.tabs.DOM.tabs[this.tabs.data.active];
      const activePaneValue = activeTab ? activeTab.dataset.tab || activeTab.dataset.asyncTab : null;
      const currentPane = this.tabs.DOM.panes.find((p) => p.dataset.pane === activePaneValue);
      if (currentPane) {
        setTimeout(() => this.tabs.updateFluidBounds(currentPane), 0);
      }
    }
    document.addEventListener("click", this.handleDocumentClick);
    document.addEventListener("keydown", this.handleKeyDown);
  }
  upgradeToFullOpen(targetTab) {
    this.state.isScrollPop = false;
    this.DOM.html.setAttribute("contact-open", "true");
    this.DOM.html.style.overflow = "hidden";
    if (this.tabs) {
      if (targetTab && targetTab !== "true") {
        const index = this.tabs.getTabIndexByPaneValue(targetTab);
        if (index !== -1) this.tabs.setActive(index, true);
      } else {
        this.tabs.setActive(0, true);
      }
    }
  }
  close() {
    if (!this.state.isOpen) return;
    this.state.isOpen = false;
    this.state.isScrollPop = false;
    this.DOM.html.removeAttribute("contact-open");
    this.DOM.html.style.overflow = "";
    this.DOM.dialog.setAttribute("aria-hidden", "true");
    if (this.tabs) {
      this.tabs.setActive(0, true);
    }
    const allPanes = document.querySelectorAll("[data-contact-widget] [data-pane]");
    allPanes.forEach((p) => {
      if (p.dataset.pane === "success") {
        p.removeAttribute("data-active");
      }
    });
    document.removeEventListener("click", this.handleDocumentClick);
    document.removeEventListener("keydown", this.handleKeyDown);
  }
  handleKeyDown(e2) {
    if (e2.key === "Escape") this.close();
  }
  handleDocumentClick(e2) {
    if (this.DOM.widget && !this.DOM.widget.contains(e2.target) && !e2.target.closest("[data-contact-toggle]")) {
      this.close();
    }
  }
  destroy() {
    if (this.tabs) this.tabs.destroy();
    if (this.scrollObserver) this.scrollObserver.disconnect();
    document.removeEventListener("click", this.handleDocumentClick);
    document.removeEventListener("keydown", this.handleKeyDown);
  }
}
function initContact() {
  document.querySelector("[data-contact]") ? new Contact(document.documentElement) : null;
}
const isMobile = window.matchMedia("(max-width: 768px)").matches || "ontouchstart" in window || navigator.maxTouchPoints > 0;
const isWindow = navigator.platform.toUpperCase().indexOf("WIN") > -1;
window.addEventListener("popstate", () => {
  document.documentElement.setAttribute("data-transition-out", "true");
});
document.addEventListener("click", (e2) => {
  if (e2.target.closest(".is-dragged") || e2.target.closest("[data-carousel-scroll]")?.classList.contains("is-dragged")) {
    e2.preventDefault();
    e2.stopImmediatePropagation();
    return;
  }
  const link = e2.target.closest("a");
  if (!link || link.target === "_blank" || link.dataset.asyncTab || link.dataset.tabPrev) return;
  const url = new URL(link.href, window.location.origin);
  const isInternal = url.hostname === window.location.hostname;
  const isSpecialClick = e2.metaKey || e2.ctrlKey || e2.shiftKey || e2.which === 2;
  if (isInternal && (link.hasAttribute("data-scroll-to") || link.hash !== "")) {
    if (url.pathname === window.location.pathname) {
      const targetSelector = link.hash || link.getAttribute("data-scroll-to") || link.getAttribute("href");
      if (targetSelector && targetSelector.startsWith("#")) {
        const targetElement = document.querySelector(targetSelector);
        console.log(targetSelector);
        if (targetElement) {
          e2.preventDefault();
          e2.stopImmediatePropagation();
          history.pushState(null, null, targetSelector);
          const scrollInstance = window.SCROLL || (typeof SCROLL !== "undefined" ? SCROLL : null);
          if (scrollInstance && typeof scrollInstance.scrollTo === "function") {
            scrollInstance.scrollTo(targetElement, {
              offset: 0,
              duration: 1.2
            });
          } else {
            targetElement.scrollIntoView({ behavior: "smooth" });
          }
          return;
        }
      }
    }
  }
  if (isInternal && !isSpecialClick) {
    if (url.pathname === window.location.pathname && url.hash !== "") return;
    e2.preventDefault();
    document.documentElement.setAttribute("data-transition-out", "true");
    setTimeout(() => {
      window.location.href = link.href;
    }, 800);
  }
}, true);
window.addEventListener("pageshow", (event) => {
  const isBackForward = event.persisted || window.performance && window.performance.getEntriesByType("navigation")[0]?.type === "back_forward" || window.performance && window.performance.navigation?.type === 2;
  if (isBackForward) {
    document.documentElement.removeAttribute("data-loading");
    document.documentElement.removeAttribute("data-transition-out");
    document.documentElement.setAttribute("data-transition", "true");
    if (window.SCROLL && typeof window.SCROLL.start === "function") {
      window.SCROLL.start();
    }
    console.log("Page restored from back/forward history. Loader cleared.");
  }
});
const init = async () => {
  console.log("Init components: ");
  const components = [
    initScroll,
    initReveals,
    initNavbar,
    initTabs,
    initCollapsibles,
    initCarousels,
    initContact,
    initProjectSearch
  ];
  await Promise.all(components.map(async (fn) => {
    if (typeof fn === "function") {
      try {
        await fn();
      } catch (err) {
        console.error("Error initializing component:", fn.name || "anonymous", err);
      }
    }
  }));
  if (typeof REVEAL !== "undefined" && REVEAL && typeof REVEAL.enable === "function") {
    REVEAL.enable();
  }
  requestAnimationFrame(() => {
    document.documentElement.setAttribute("data-transition", "true");
    setTimeout(() => {
      document.documentElement.removeAttribute("data-loading");
      console.log("App fully initialized.");
    }, 600);
  });
};
const startApp = async () => {
  document.documentElement.setAttribute("data-loading", "true");
  const PAGE = new Promise((resolve) => {
    if (typeof Loader === "undefined") {
      resolve();
      return;
    }
    const loader = new Loader(
      (percent) => {
        document.querySelector("[data-loader]")?.style.setProperty("--progress", percent);
      },
      () => {
        resolve();
      }
    );
    loader.init();
  });
  try {
    await Promise.race([
      PAGE,
      new Promise((res) => setTimeout(res, 4e3))
    ]);
  } catch (err) {
    console.warn("Preload failed, initializing anyway", err);
  }
  await init();
};
document.addEventListener("DOMContentLoaded", async () => {
  startApp();
});
