import { ADD_FILES } from '../action-types';
import { UPDATE_FILE_UPLOAD_PROGRESS } from '../action-types';

export const addFiles = files => ({
    type: ADD_FILES,
    payload: files
});

export const updateFileUploadProgress = (fileID, progressPercent) => ({
    type: UPDATE_FILE_UPLOAD_PROGRESS,
    payload: {fileID, progressPercent}
});
