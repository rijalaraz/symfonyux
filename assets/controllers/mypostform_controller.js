import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    async initialize() {

    }

    connect() {

        $("form").on('input', '#post_title', function() {

            $("#post_slug").val($(this).val());

        });

    }
}
