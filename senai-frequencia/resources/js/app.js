import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

function applyMask(value, pattern) {
    const digits = value.replace(/\D/g, '');
    let formatted = '';
    let digitIndex = 0;

    for (const char of pattern) {
        if (digitIndex >= digits.length) {
            break;
        }

        if (char === '0') {
            formatted += digits[digitIndex++];
        } else {
            formatted += char;
        }
    }

    return formatted;
}

function bindMaskInput(input) {
    const maskType = input.dataset.mask;
    const patterns = {
        cpf: '000.000.000-00',
        cnpj: '00.000.000/0000-00',
    };

    const pattern = patterns[maskType];
    if (!pattern) {
        return;
    }

    const formatValue = () => {
        input.value = applyMask(input.value, pattern);
    };

    input.addEventListener('input', formatValue);
    input.addEventListener('paste', () => setTimeout(formatValue, 0));
    formatValue();
}

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-mask]').forEach(bindMaskInput);
});

Alpine.start();
