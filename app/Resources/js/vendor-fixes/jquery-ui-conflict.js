//Fix collisions with other jQuery Frameworks

//conflict with Bootstraps tooltip
$.widget.bridge('uiTooltip', $.ui.tooltip);