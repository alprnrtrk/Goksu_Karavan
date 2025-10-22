(() => {
  const containers = document.querySelectorAll('[data-auriel-repeater]');

  if (!containers.length) {
    return;
  }

  const placeholderMarkup = (wrapper) => {
    const text = wrapper.getAttribute('data-placeholder-text') || 'No image selected';
    return `<div class="auriel-repeater-card__image-placeholder">${text}</div>`;
  };

  containers.forEach((container) => {
    const list = container.querySelector('[data-auriel-repeater-list]');
    const addButton = container.querySelector('[data-auriel-repeater-add]');
    const templateId = container.getAttribute('data-repeater-template');
    const fieldPrefix = container.getAttribute('data-field-prefix') || '';

    if (!list || !addButton || !templateId || !fieldPrefix) {
      return;
    }

    const template = document.getElementById(templateId);
    if (!template) {
      return;
    }

    const updateFieldNames = () => {
      const cards = list.querySelectorAll('[data-auriel-repeater-card]');
      cards.forEach((card, index) => {
        card.setAttribute('data-index', String(index));
        const fields = card.querySelectorAll('input[name], textarea[name]');
        fields.forEach((field) => {
          const name = field.getAttribute('name');
          if (!name) {
            return;
          }
          const pattern = new RegExp(`${fieldPrefix}\\[(?:__index__|\\d+)\\]`);
          const updated = name.replace(pattern, `${fieldPrefix}[${index}]`);
          field.setAttribute('name', updated);
        });
      });
    };

    const addCard = () => {
      const fragment = template.content.cloneNode(true);
      const card = fragment.querySelector('[data-auriel-repeater-card]');
      if (!card) {
        return;
      }
      list.appendChild(card);
      updateFieldNames();
    };

    const moveCard = (card, direction) => {
      const sibling = direction < 0 ? card.previousElementSibling : card.nextElementSibling;
      if (!sibling) {
        return;
      }
      if (direction < 0) {
        list.insertBefore(card, sibling);
      } else {
        list.insertBefore(sibling, card);
      }
      updateFieldNames();
    };

    const removeCard = (card) => {
      card.remove();
      updateFieldNames();
    };

    const setImage = (card, attachment) => {
      const previewWrapper = card.querySelector('[data-auriel-repeater-image-preview]');
      const input = card.querySelector('[data-auriel-repeater-image-id]');
      if (!previewWrapper || !input) {
        return;
      }
      const imageMarkup = `<img src="${attachment.url}" alt="${attachment.alt || ''}" class="auriel-repeater-card__image-preview" />`;
      previewWrapper.innerHTML = imageMarkup;
      input.value = attachment.id;
    };

    const clearImage = (card) => {
      const previewWrapper = card.querySelector('[data-auriel-repeater-image-preview]');
      const input = card.querySelector('[data-auriel-repeater-image-id]');
      if (!previewWrapper || !input) {
        return;
      }
      previewWrapper.innerHTML = placeholderMarkup(previewWrapper);
      input.value = '';
    };

    addButton.addEventListener('click', (event) => {
      event.preventDefault();
      addCard();
    });

    list.addEventListener('click', (event) => {
      const target = event.target;
      if (!(target instanceof HTMLElement)) {
        return;
      }

      const card = target.closest('[data-auriel-repeater-card]');
      if (!card) {
        return;
      }

      if (target.matches('[data-auriel-repeater-remove]')) {
        event.preventDefault();
        removeCard(card);
        return;
      }

      if (target.matches('[data-auriel-repeater-move-up]')) {
        event.preventDefault();
        moveCard(card, -1);
        return;
      }

      if (target.matches('[data-auriel-repeater-move-down]')) {
        event.preventDefault();
        moveCard(card, 1);
        return;
      }

      if (target.matches('[data-auriel-repeater-select-image]')) {
        event.preventDefault();
        const frame = wp.media({
          title: 'Select image',
          multiple: false,
          library: {
            type: ['image'],
          },
        });

        frame.on('select', () => {
          const attachment = frame.state().get('selection').first().toJSON();
          setImage(card, attachment);
        });

        frame.open();
        return;
      }

      if (target.matches('[data-auriel-repeater-clear-image]')) {
        event.preventDefault();
        clearImage(card);
      }
    });

    updateFieldNames();
  });
})();
