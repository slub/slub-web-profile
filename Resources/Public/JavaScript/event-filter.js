import * as buildFilter from './Service/Event/Filter/build.js';
import * as executeFilter from './Service/Event/Filter/execute.js';

buildFilter.initialize();
executeFilter.listenEvents();
