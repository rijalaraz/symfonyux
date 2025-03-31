import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static datasetsDatas = []

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


        // function randomNumber(min = 0, max = 100) {
        //     if (min > max) {
        //       let temp = max;
        //       max = min;
        //       min = temp;
        //     }
          
        //     if (min <= 0) {
        //       return Math.floor(Math.random() * (max + Math.abs(min) + 1)) + min;
        //     } else {
        //       return Math.floor(Math.random() * (max - min + 1)) + min;
        //     }
        // }


        var _this = this;

        $('.example-wrapper').on('input change', 'input[type="range"]', function(e){
            switch(e.type) {
                case 'input':
                    $("#final").html( $(this).val() );
                    break;

                case 'change':

                    const multiplier = $(this).val() / 50;

                    const datasetsDatas = _this.datasetsDatas.map(datasetsData => datasetsData.map(data => data * multiplier));

                    event.detail.chart.data.datasets.forEach((dataset, index) => {

                        dataset.data = datasetsDatas[index];
                        // element.data = [$(this).val() , randomNumber(), randomNumber(), randomNumber(), randomNumber(), randomNumber(), randomNumber()]
                    });

                    event.detail.chart.update();

                    break;
            }
        });

    }
}
