(() => {
  const ready = (callback) => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', callback);
    } else {
      callback();
    }
  };

  const initImageField = (wrapper) => {
    const selectButton = wrapper.querySelector('[data-image-select]');
    const removeButton = wrapper.querySelector('[data-image-remove]');
    const hiddenInput = wrapper.querySelector('[data-image-input]');
    const preview = wrapper.querySelector('[data-image-preview]');

    if (!selectButton || !removeButton || !hiddenInput || !preview) {
      return;
    }

    let frame = null;

    selectButton.addEventListener('click', (event) => {
      event.preventDefault();

      if (typeof wp === 'undefined' || !wp.media) {
        return;
      }

      if (!frame) {
        frame = wp.media({
          title: selectButton.textContent || 'Select image',
          button: {
            text: selectButton.textContent || 'Select',
          },
          multiple: false,
          library: {
            type: ['image'],
          },
        });

        frame.on('select', () => {
          const attachment = frame.state().get('selection').first();
          if (!attachment) {
            return;
          }

          const data = attachment.toJSON();
          hiddenInput.value = String(data.id || '');

          const source =
            (data.sizes && data.sizes.medium && data.sizes.medium.url) ||
            data.url ||
            '';

          const alt = data.alt || '';
          preview.innerHTML = source
            ? `<img src="${source}" alt="${alt}" class="auriel-partials-image-preview" />`
            : '';
        });
      }

      frame.open();
    });

    removeButton.addEventListener('click', (event) => {
      event.preventDefault();
      hiddenInput.value = '';
      preview.innerHTML = '';
    });
  };

  const initRepeater = (repeater) => {
    const itemsWrapper = repeater.querySelector('[data-repeater-items]');
    const template = repeater.querySelector('[data-repeater-template]');
    const addButton = repeater.querySelector('[data-repeater-add]');

    if (!itemsWrapper || !template || !addButton) {
      return;
    }

    const createItem = (index) => {
      const markup = template.innerHTML.replace(/__INDEX__/g, String(index));
      const wrapper = document.createElement('div');
      wrapper.innerHTML = markup.trim();
      return wrapper.firstElementChild;
    };

    const normaliseFieldNames = () => {
      const items = Array.from(itemsWrapper.querySelectorAll('[data-repeater-item]'));
      items.forEach((item, index) => {
        item.querySelectorAll('[name]').forEach((field) => {
          const name = field.getAttribute('name');
          if (!name) {
            return;
          }
          field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
        });
      });
    };

    addButton.addEventListener('click', (event) => {
      event.preventDefault();
      const nextIndex = itemsWrapper.querySelectorAll('[data-repeater-item]').length;
      const item = createItem(nextIndex);
      if (item) {
        itemsWrapper.appendChild(item);
        item.querySelectorAll('[data-partial-image]').forEach(initImageField);
        normaliseFieldNames();
      }
    });

    itemsWrapper.addEventListener('click', (event) => {
      const trigger = event.target;
      if (!(trigger instanceof HTMLElement)) {
        return;
      }

      if (trigger.matches('[data-repeater-remove]')) {
        event.preventDefault();
        const item = trigger.closest('[data-repeater-item]');
        if (item) {
          item.remove();
          normaliseFieldNames();
        }
        return;
      }
    });

    normaliseFieldNames();
  };

  const initPartialMeta = (container) => {
    container.querySelectorAll('[data-partial-image]').forEach((wrapper) => {
      initImageField(wrapper);
    });

    container.querySelectorAll('[data-partial-repeater]').forEach((repeater) => {
      initRepeater(repeater);
    });
  };

  ready(() => {
    document.querySelectorAll('[data-partial-meta]').forEach((metaBox) => {
      initPartialMeta(metaBox);
    });
  });
})();
