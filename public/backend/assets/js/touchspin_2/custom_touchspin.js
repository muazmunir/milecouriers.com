function initializeTouchspin(wrapper) {
  const inputField = wrapper.querySelector('.input-touchspin');
  const incrementButton = wrapper.querySelector('.increment-touchspin');
  const decrementButton = wrapper.querySelector('.decrement-touchspin');

  // Ensure all elements are present before proceeding
  if (!inputField || !incrementButton || !decrementButton) {
      console.warn("Touchspin elements not found in wrapper:", wrapper);
      return; // Skip this iteration if any element is missing
  }

  // Set the initial value and define step based on input name
  let step;
  if (inputField.name === 'quantity[]') {
      inputField.value = parseInt(inputField.value) || 1; // Start at 1 for quantity
      step = 1;
  } else if (inputField.name === 'weight[]') {
      inputField.value = parseFloat(inputField.value) || 0.5; // Start at 0.5 for weight
      step = 0.5;
  } else {
      console.warn("Unrecognized input name:", inputField.name);
      return; // Skip if the input name does not match expected values
  }

  // Increment button functionality
  incrementButton.addEventListener('click', () => {
      let currentValue = parseFloat(inputField.value) || 0;
      currentValue += step;
      inputField.value = currentValue.toFixed(step === 0.5 ? 1 : 0); // Use 1 decimal for weight
  });

  // Decrement button functionality
  decrementButton.addEventListener('click', () => {
      let currentValue = parseFloat(inputField.value) || 0;
      if (currentValue > step) {
          currentValue -= step;
          inputField.value = currentValue.toFixed(step === 0.5 ? 1 : 0); // Use 1 decimal for weight
      }
  });
}

// Initialize touchspin on all existing wrappers
document.querySelectorAll('.touchspin-wrapper').forEach(initializeTouchspin);

// When cloning, reinitialize on the cloned wrapper
function cloneTouchspinWrapper(wrapper) {
  const clonedWrapper = wrapper.cloneNode(true);
  wrapper.parentNode.appendChild(clonedWrapper);
  initializeTouchspin(clonedWrapper); // Reinitialize touchspin on the cloned element
}

// Example usage: Clone button click event
document.querySelector('.clone-button').addEventListener('click', () => {
  const wrapper = document.querySelector('.touchspin-wrapper');
  if (wrapper) cloneTouchspinWrapper(wrapper);
});
