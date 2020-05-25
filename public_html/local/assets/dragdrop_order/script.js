function initDraggableOrderControl(params) {
    var data = JSON.parse(params.data);
    if (data) {
        BX.loadScript('/bitrix/js/main/core/core_dragdrop.js', function() {
            (function bx_dnd_order_waiter() {
                if (!!BX.DragDrop)
                    window['dnd_parameter_' + params.propertyID] = new DragNDropOrderParameterControl(data, params);
                else
                    setTimeout(bx_dnd_order_waiter, 50);
            })();
        });
    }
}

function DragNDropOrderParameterControl(items, params) {
    var rand = BX.util.getRandomString(5);

    this.params = params || {};
    this.items = this.getSortedItems(items);

    this.rootElementId = 'dnd_params_container_' + this.params.propertyID + '_' + rand;
    this.classNames = {
        dragItem: 'dnd-order-draggable-item-' + this.params.propertyID + '-' + rand,
        dndControlContainer: 'dnd-order-draggable-control-container',
        dndControl: 'dnd-order-draggable-control dnd-order-draggable-item',
    };

    BX.loadCSS(this.getPath() + '/style.css?' + rand);
    this.buildNodes();
    this.initDragDrop();
}

DragNDropOrderParameterControl.prototype = {
    getPath: function() {
        var path = this.params.propertyParams.JS_FILE.split('/');

        path.pop();

        return path.join('/');
    },

    getSortedItems: function(items) {
        if (!items)
            return [];

        var inputValue = this.params.oInput.value || this.params.propertyParams.DEFAULT || '',
            result = [],
            k;

        var values = inputValue.split(',');
        for (k in values) {
            if (values.hasOwnProperty(k)) {
                values[k] = BX.util.trim(values[k]);
                if (items[values[k]]) {
                    result.push({
                        value: values[k],
                        message: items[values[k]],
                        disabled: false
                    });
                }
            }
        }

        for (k in items) {
            if (items.hasOwnProperty(k) && !BX.util.in_array(k, values)) {
                result.push({
                    value: k,
                    message: items[k],
                    disabled: true
                });
            }
        }

        return result;
    },

    buildNodes: function() {
        var self = this;
        // create control container
        var baseNode = BX.create('DIV', {
            props: { className: this.classNames.dndControlContainer, id: this.rootElementId }
        });

        // append controls to container
        for (var k in this.items) {
            if (this.items.hasOwnProperty(k)) {
                baseNode.appendChild(
                    BX.create('DIV', {
                        attrs: {
                            'data-value': this.items[k].value,
                            'data-disabled': this.items[k].disabled
                        },
                        props: {
                            className: this.classNames.dndControl + ' ' + this.classNames.dragItem,
                            title: 'Перетащите для сортировки или нажмите дважды для (де)активации',
                        },
                        text: this.items[k].message,
                        events: {
                            dblclick: function(e) {
                                if (!!this.getAttribute('data-disabled')) {
                                    this.removeAttribute('data-disabled');
                                } else {
                                    this.setAttribute('data-disabled', true);
                                }

                                self.saveData();
                            }
                        }
                    })
                );
            }
        }

        // append prepared elements to field
        this.params.oCont.appendChild(baseNode);
    },

    initDragDrop: function() {
        if (BX.isNodeInDom(this.params.oCont)) {
            this.dragdrop = BX.DragDrop.create({
                dragItemClassName: this.classNames.dragItem,
                dragItemControlClassName: this.classNames.dndControl.split(' ')[0],
                sortable: { rootElem: BX(this.rootElementId) },
                dragEnd: BX.delegate(function(eventObj, dragElement, event) {
                    // enable item on drag end
                    eventObj.removeAttribute('data-disabled');
                    // save data on drag end
                    this.saveData();
                }, this)
            });
        } else {
            setTimeout(BX.delegate(this.initDragDrop, this), 50);
        }
    },

    saveData: function() {
        // get all control items
        var items = this.params.oCont.querySelectorAll('.' + this.classNames.dragItem),
            arr = [];

        for (var k in items) {
            // if not disabled
            if (items.hasOwnProperty(k) && !items[k].getAttribute('data-disabled')) {
                // insert value from attribute data-value
                arr.push(items[k].getAttribute('data-value'));
            }
        }

        // join arr values to string
        this.params.oInput.value = arr.join(',');
    }
};