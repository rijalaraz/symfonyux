import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

    async initialize() {

        const component = await getComponent(this.element);

        const slugify = (text) => {
            return text
              .toString()                   // Cast to string (optional)
              .normalize('NFKD')            // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
              .toLowerCase()                // Convert the string to lowercase letters
              .trim()                       // Remove whitespace from both sides of a string (optional)
              .replace(/\s+/g, '-')         // Replace spaces with -
              .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
              .replace(/\_/g,'-')           // Replace _ with -
              .replace(/\-\-+/g, '-')       // Replace multiple - with single -
              .replace(/\-$/g, '');         // Remove trailing -
        }

        $("body").on('input', '#blog_title', function() {

            component.emit('titleChanged', { slug : slugify($(this).val()) });

        });
    }

}
