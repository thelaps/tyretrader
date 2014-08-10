// custom checkbox module
jcf.addModule({
	name:'checkbox',
	selector:'input[type=checkbox]',
	defaultOptions: {
		wrapperClass:'chk-area',
		focusClass:'chk-focus',
		checkedClass:'chk-checked',
		labelActiveClass:'chk-label-active',
		uncheckedClass:'chk-unchecked',
		disabledClass:'chk-disabled',
		chkStructure:'<span></span>'
	},
	setupWrapper: function(){
		jcf.lib.addClass(this.fakeElement, this.options.wrapperClass);
		this.fakeElement.innerHTML = this.options.chkStructure;
		this.realElement.parentNode.insertBefore(this.fakeElement, this.realElement);
		this.refreshState();
		this.addEvents();
	},
	addEvents: function(){
		jcf.lib.event.add(this.fakeElement, 'click', this.toggle, this);
		if(jcf.lib.browser.msie && jcf.lib.browser.version < 7 && this.labelFor && !this.labelFor.getAttribute('htmlFor')) {
			jcf.lib.event.add(this.labelFor, 'mousedown', this.onLabelMouseDown);
		}
	},
	onFakeMouseDown: function(e){
		jcf.modules[this.name].superclass.onFakeMouseDown.apply(this, arguments);

		// IE image inside label fix
		if(jcf.lib.browser.msie && e.target && e.target.tagName.toLowerCase() == 'img') {
			if(jcf.lib.browser.version < 7) {
				if(this.labelFor && this.labelFor.getAttribute('htmlFor')) {
					this.toggle.apply(this);
				}
			} else {
				this.toggle.apply(this);
			}
		}
		return false;
	},
	onLabelMouseDown: function(e){
		jcf.modules[this.name].superclass.onFakeMouseDown.apply(this, arguments);
		this.toggle.apply(this);
	},
	toggle: function(e){
		if(!this.realElement.disabled) {
			if(this.realElement.checked) {
				this.realElement.checked = false;
			} else {
				this.realElement.checked = true;
			}
		}
		//jcf.lib.fireEvent(this.realElement, 'click');
		jcf.lib.fireEvent(this.realElement, 'change');
		this.refreshState();
		return false;
	},
    resetState: function() {
        if(this.realElement.defaultChecked) {
            jcf.lib.addClass(this.fakeElement, this.options.checkedClass);
            jcf.lib.removeClass(this.fakeElement, this.options.uncheckedClass);
            if(this.labelFor) {
                jcf.lib.addClass(this.labelFor, this.options.labelActiveClass);
            }
        } else {
            jcf.lib.removeClass(this.fakeElement, this.options.checkedClass);
            jcf.lib.addClass(this.fakeElement, this.options.uncheckedClass);
            if(this.labelFor) {
                jcf.lib.removeClass(this.labelFor, this.options.labelActiveClass);
            }
        }
    },
	refreshState: function(){
		if(this.realElement.checked) {
			jcf.lib.addClass(this.fakeElement, this.options.checkedClass);
			jcf.lib.removeClass(this.fakeElement, this.options.uncheckedClass);
			if(this.labelFor) {
				jcf.lib.addClass(this.labelFor, this.options.labelActiveClass);
			}
		} else {
			jcf.lib.removeClass(this.fakeElement, this.options.checkedClass);
			jcf.lib.addClass(this.fakeElement, this.options.uncheckedClass);
			if(this.labelFor) {
				jcf.lib.removeClass(this.labelFor, this.options.labelActiveClass);
			}
		}
		if(this.realElement.disabled) {
			jcf.lib.addClass(this.fakeElement, this.options.disabledClass);
		} else {
			jcf.lib.removeClass(this.fakeElement, this.options.disabledClass);
		}
	}
});