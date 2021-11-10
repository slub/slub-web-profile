import * as buildFilter from './Service/Event/Filter/build.js';
import * as dropdownFilter from './Service/Event/Filter/dropdown.js';
import * as executeFilter from './Service/Event/Filter/execute.js';

buildFilter.initialize();
dropdownFilter.listenEvents();
executeFilter.listenEvents();
