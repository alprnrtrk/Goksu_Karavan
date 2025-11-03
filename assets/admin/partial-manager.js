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

  const initGalleryField = (wrapper) => {
    const selectButton = wrapper.querySelector('[data-gallery-select]');
    const addButton = wrapper.querySelector('[data-gallery-add]');
    const clearButton = wrapper.querySelector('[data-gallery-clear]');
    const hiddenInput = wrapper.querySelector('[data-gallery-input]');
    const list = wrapper.querySelector('[data-gallery-list]');

    if (!selectButton || !hiddenInput || !list) {
      return;
    }

    let images = Array.from(list.querySelectorAll('[data-gallery-item]'))
      .map((item) => {
        const id = parseInt(item.getAttribute('data-image-id') || '', 10);
        if (!id) {
          return null;
        }

        const existingImage = item.querySelector('img');
        const src =
          item.getAttribute('data-thumb-src') ||
          (existingImage ? existingImage.getAttribute('src') || '' : '') ||
          '';
        const alt =
          item.getAttribute('data-thumb-alt') ||
          (existingImage ? existingImage.getAttribute('alt') || '' : '') ||
          '';

        return {
          id,
          src,
          alt,
        };
      })
      .filter((entry) => entry !== null);

    const syncInput = () => {
      hiddenInput.value = images.map((image) => image.id).join(',');
    };

    const render = () => {
      list.innerHTML = '';

      images.forEach((image, index) => {
        const item = document.createElement('div');
        item.className = 'auriel-partials-gallery-item';
        item.dataset.galleryItem = '';
        item.dataset.imageId = String(image.id);
        if (image.src) {
          item.dataset.thumbSrc = image.src;
        }
        if (image.alt) {
          item.dataset.thumbAlt = image.alt;
        }

        const thumb = document.createElement('div');
        thumb.className = 'auriel-partials-gallery-thumb';
        if (image.src) {
          const preview = document.createElement('img');
          preview.className = 'auriel-partials-gallery-thumb-img';
          preview.src = image.src;
          preview.alt = image.alt || '';
          thumb.appendChild(preview);
        }
        item.appendChild(thumb);

        const actions = document.createElement('div');
        actions.className = 'auriel-partials-gallery-item-actions';

        const moveUpButton = document.createElement('button');
        moveUpButton.type = 'button';
        moveUpButton.className = 'button button-small';
        moveUpButton.setAttribute('data-gallery-move-up', '');
        moveUpButton.textContent = 'Move up';
        if (index === 0) {
          moveUpButton.disabled = true;
        }
        actions.appendChild(moveUpButton);

        const moveDownButton = document.createElement('button');
        moveDownButton.type = 'button';
        moveDownButton.className = 'button button-small';
        moveDownButton.setAttribute('data-gallery-move-down', '');
        moveDownButton.textContent = 'Move down';
        if (index === images.length - 1) {
          moveDownButton.disabled = true;
        }
        actions.appendChild(moveDownButton);

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'button button-link-delete';
        removeButton.setAttribute('data-gallery-remove', '');
        removeButton.textContent = 'Remove';
        actions.appendChild(removeButton);

        item.appendChild(actions);
        list.appendChild(item);
      });

      syncInput();
    };

    render();

    let frame = null;
    let frameMode = 'replace';

    const ensureFrame = () => {
      if (frame) {
        return frame;
      }

      frame = wp.media({
        title: selectButton.textContent || 'Select images',
        button: {
          text: selectButton.textContent || 'Select',
        },
        multiple: 'toggle',
        library: {
          type: ['image'],
        },
      });

      frame.on('open', () => {
        const selection = frame.state().get('selection');
        selection.reset();

        if (frameMode === 'replace') {
          images.forEach((image) => {
            const attachment = wp.media.attachment(image.id);
            if (!attachment) {
              return;
            }
            attachment.fetch();
            selection.add(attachment);
          });
        }
      });

      frame.on('select', () => {
        const selection = frame.state().get('selection');
        const selected = [];

        selection.each((attachment) => {
          const data = attachment.toJSON();
          const src =
            (data.sizes &&
              data.sizes.thumbnail &&
              data.sizes.thumbnail.url) ||
            data.url ||
            '';

          selected.push({
            id: Number(data.id) || 0,
            src,
            alt: data.alt || data.title || '',
          });
        });

        const filteredSelected = selected.filter((image) => image.id);

        if (frameMode === 'replace') {
          images = filteredSelected;
        } else {
          const existingIds = new Set(images.map((image) => Number(image.id) || 0));
          filteredSelected.forEach((image) => {
            const imageId = Number(image.id) || 0;
            if (!imageId || existingIds.has(imageId)) {
              return;
            }
            images.push(image);
            existingIds.add(imageId);
          });
        }

        render();
      });

      return frame;
    };

    selectButton.addEventListener('click', (event) => {
      event.preventDefault();

      if (typeof wp === 'undefined' || !wp.media) {
        return;
      }

      frameMode = 'replace';
      const mediaFrame = ensureFrame();
      mediaFrame.open();
    });

    if (addButton) {
      addButton.addEventListener('click', (event) => {
        event.preventDefault();

        if (typeof wp === 'undefined' || !wp.media) {
          return;
        }

        frameMode = 'append';
        const mediaFrame = ensureFrame();
        mediaFrame.open();
      });
    }

    if (clearButton) {
      clearButton.addEventListener('click', (event) => {
        event.preventDefault();
        images = [];
        render();
      });
    }

    list.addEventListener('click', (event) => {
      const target = event.target;
      if (!(target instanceof HTMLElement)) {
        return;
      }

      const item = target.closest('[data-gallery-item]');
      if (!item) {
        return;
      }

      const id = parseInt(item.getAttribute('data-image-id') || '', 10);
      if (!id) {
        return;
      }

      if (target.matches('[data-gallery-remove]')) {
        event.preventDefault();
        images = images.filter((image) => image.id !== id);
        render();
        return;
      }

      if (target.matches('[data-gallery-move-up]')) {
        event.preventDefault();
        const index = images.findIndex((image) => image.id === id);
        if (index > 0) {
          const [entry] = images.splice(index, 1);
          images.splice(index - 1, 0, entry);
          render();
        }
        return;
      }

      if (target.matches('[data-gallery-move-down]')) {
        event.preventDefault();
        const index = images.findIndex((image) => image.id === id);
        if (index > -1 && index < images.length - 1) {
          const [entry] = images.splice(index, 1);
          images.splice(index + 1, 0, entry);
          render();
        }
      }
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
        item.querySelectorAll('[data-partial-gallery]').forEach(initGalleryField);
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

    container.querySelectorAll('[data-partial-gallery]').forEach((wrapper) => {
      initGalleryField(wrapper);
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
