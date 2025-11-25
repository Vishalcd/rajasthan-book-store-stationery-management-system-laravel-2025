class Alert {
    #alert = document.querySelector("#alert") || null;
    #time;

    constructor(time) {
        if (!this.#alert) return;
        this.#time = time;
        this._closeAlert();
    }

    _closeAlert() {
        if (this.#alert) {
            setTimeout(function () {
                this.#alert.remove();
            }, this.#time);
        }
    }
}

new Alert(8000);
