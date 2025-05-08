import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        this.element.addEventListener('chartjs:pre-connect', this._onPreConnect);
        this.element.addEventListener('chartjs:connect', this._onConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side effects
        this.element.removeEventListener('chartjs:pre-connect', this._onPreConnect);
        this.element.removeEventListener('chartjs:connect', this._onConnect);
    }

    _onPreConnect(event) {
        // The chart is not yet created
        // You can access the config that will be passed to "new Chart()"
        console.log(event.detail.config);

        this.datasetsDatas = event.detail.config.data.datasets.map(dataset => dataset.data);

        // For instance you can format Y axis
        // To avoid overriding existing config, you should distinguish 3 cases:
        // # 3. Existing Y axis config => update it
        event.detail.config.options.scales.y.ticks = {
            callback: function (value, index, values) {
                return value + ' votes';
            },
        };

    }

    _onConnect(event) {
        // The chart was just created
        console.log(event.detail.chart); // You can access the chart instance using the event details

        // For instance you can listen to additional events
        event.detail.chart.options.onHover = (mouseEvent) => {
            /* ... */
        };
        event.detail.chart.options.onClick = (mouseEvent) => {
            /* ... */
        };

        $('.example-wrapper').on('input change', 'input[type="range"]', function(e){
            switch(e.type) {
                case 'input':
                    $("#final").html($(this).val());
                    break;

                case 'change':
                    $("#final").html($(this).val());
                    break;
            }
        });
    }
}
