import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://symfony.com/bundles/StimulusBundle/current/index.html#lazy-stimulus-controllers
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['titre', 'sakafo']
    static values = {
        breakfast: String,
    }
    static classes = ['andrahoy']

    async initialize() {
        // Called once when the controller is first instantiated (per element)

        // Here you can initialize variables, create scoped callables for event
        // listeners, instantiate external libraries, etc.
        this._changeTitle = this.changeTitle.bind(this)
        this._changeMeal = this.changeMeal.bind(this)

        this.component = await getComponent(this.element);
    }

    connect() {
        // Called every time the controller is connected to the DOM
        // (on page load, when it's added to the DOM, moved in the DOM, etc.)

        // Here you can add event listeners on the element or target elements,
        // add or remove classes, attributes, dispatch custom events, etc.
        this.titreTarget.addEventListener('input', this._changeTitle)
        this.sakafoTarget.addEventListener('change', this._changeMeal)
    }

    // Add custom controller actions here
    changeTitle(event) {
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

        this.component.emit('title:changed', {
            slug : slugify(event.target.value)
        });

        // this.fooTarget.classList.toggle(this.bazClass)
    }

    changeMeal(event) {
        // this.fooTarget.classList.toggle(this.bazClass) 
        this.component.emit('meal:changed', {
            meal : event.target.value
        });
    }

    disconnect() {
        // Called anytime its element is disconnected from the DOM
        // (on page change, when it's removed from or moved in the DOM, etc.)

        // Here you should remove all event listeners added in "connect()" 
        // this.fooTarget.removeEventListener('click', this._fooBar)
    }
}
