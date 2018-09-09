import { createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';

import FileListReducer from './reducers/FileListReducer';

export default createStore(FileListReducer, applyMiddleware(thunk));
