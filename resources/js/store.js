import { createStore, combineReducers } from 'redux';
import FileListReducer from './reducers/FileListReducer';

export default createStore(combineReducers({ FileListReducer }));
