(function(window){
  try {
    var data = (typeof window.pstoolkitColorPickerL10n !== 'undefined') ? window.pstoolkitColorPickerL10n : {
      clear: 'Leeren',
      clearAriaLabel: 'Leere Farbe',
      defaultString: 'Standard',
      defaultAriaLabel: 'Wähle Standardfarbe',
      pick: 'Wähle Farbe',
      defaultLabel: 'Farbwert',
      current: 'Aktuelle Farbe'
    };
    if (typeof window.wpColorPickerL10n !== 'undefined') {
      try { delete window.wpColorPickerL10n; } catch(e) {}
      window.wpColorPickerL10n = data;
    } else {
      window.wpColorPickerL10n = data;
    }
  } catch (e) {
    // noop
  }
})(window);
