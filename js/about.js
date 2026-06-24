function handleSelection(element) {
  // 1. Check if the card clicked is already selected
  const isAlreadySelected = element.classList.contains('selected');

  // 2. Reset ALL cards to original color (white)
  const allCards = document.querySelectorAll('.service-card');
  allCards.forEach(card => {
    card.classList.remove('selected');
  });

  // 3. If the card wasn't already green, make it green.
  // If it WAS already green, it stays white (because of step 2).
  if (!isAlreadySelected) {
    element.classList.add('selected');
  }
}
function handleTouch(element) {
  // 1. Remove 'selected' from all other boxes
  const allcards = document.querySelectorAll('.service-card');
  allBoxes.forEach(box => {
    box.classList.remove('selected');
  });

  // 2. Add 'selected' ONLY to the one you just touched
  element.classList.add('selected');
}
