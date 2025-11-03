const SELECTORS = {
  grid: '[data-gallery-own-grid]',
  loadMoreButton: '[data-gallery-own-load-more]',
};

function revealBatch(grid, size) {
  if (!grid) {
    return false;
  }

  const hiddenItems = Array.from(grid.querySelectorAll('[data-gallery-hidden="true"]'));
  if (!hiddenItems.length) {
    return false;
  }

  hiddenItems.slice(0, size).forEach((item) => {
    item.style.removeProperty('display');
    item.removeAttribute('data-gallery-hidden');
  });

  return grid.querySelector('[data-gallery-hidden="true"]') === null;
}

function initLoadMore(grid, button) {
  if (!grid || !button) {
    return;
  }

  const batchSize = Number(grid.getAttribute('data-gallery-batch')) || 9;

  button.addEventListener('click', () => {
    const isFinished = revealBatch(grid, batchSize);

    if (isFinished) {
      button.style.display = 'none';
    }
  });
}

export default function initGalleryOwn(partialRoot) {
  if (!partialRoot) {
    return;
  }

  const grid = partialRoot.querySelector(SELECTORS.grid);
  const button = partialRoot.querySelector(SELECTORS.loadMoreButton);

  if (!grid) {
    return;
  }

  initLoadMore(grid, button);
}
