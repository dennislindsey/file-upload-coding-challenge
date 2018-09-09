import axios from 'axios';

import {ADD_FILES} from '../action-types';
import {
    UPDATE_FILE_UPLOAD_PROGRESS,
    DELETE_FILE,
    INIT_APP_STARTED,
    INIT_APP_FINISHED,
    INIT_APP_FAILED
} from '../action-types';

import {baseURL} from '../config';

export const addFiles = files => ({
    type: ADD_FILES,
    payload: files
});

export const updateFileUploadProgress = (fileID, progressPercent) => ({
    type: UPDATE_FILE_UPLOAD_PROGRESS,
    payload: {fileID, progressPercent}
});

export const deleteFile = fileID => ({
    type: DELETE_FILE,
    payload: {fileID}
});

export const initApp = () => dispatch => {
    dispatch(initAppStarted());

    axios.get(baseURL + '/api/file')
        .then(res => {
            dispatch(initAppFinished(res.data));
            dispatch(addFiles(res.data.map(file => ({
                fileID: file.id,
                fileName: file.filename,
                url: file.url,
                uploadProgressPercent: 0,
                uploadComplete: true,
            }))));
        })
        .catch(res => dispatch(initAppFailed(res.data)));
};

const initAppStarted = () => ({
    type: INIT_APP_STARTED
});

const initAppFinished = () => ({
    type: INIT_APP_FINISHED
});

const initAppFailed = error => ({
    type: INIT_APP_FAILED,
    payload: {error}
});