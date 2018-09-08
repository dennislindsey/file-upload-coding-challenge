import React, {Component} from 'react';
import Dropzone from 'react-dropzone'
import axios from 'axios';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';

import {baseURL} from '../config';
import {addFiles, updateFileUploadProgress} from '../actions';

class FileUploader extends Component {
    uploadChunk(fileID, fileName, endOfFile, chunk) {
        return axios.post(baseURL + '/api/file', {
            fileID,
            fileName,
            endOfFile,
            chunk
        });
    }

    abortUpload() {
    }

    onDrop(acceptedFiles, rejectedFiles) {
        if (acceptedFiles) {
            acceptedFiles = acceptedFiles.map(file => ({
                fileID: Math.random().toString(36).substring(7),
                file
            }));
            this.props.actions.addFiles(acceptedFiles.map(file => ({
                fileID: file.fileID,
                fileName: file.file.name,
                uploadInProgress: true,
                uploadProgressPercent: 0
            })));
        }

        acceptedFiles.forEach(acceptedFile => {
            const reader = new FileReader();
            const chunkSize = 1024 * 1024;
            let offset = 0;

            reader.onloadend = e => {
                if (e.target.readyState != FileReader.DONE) {
                    return;
                }

                offset += chunkSize;

                this.uploadChunk(acceptedFile.fileID, acceptedFile.file.name, offset >= acceptedFile.file.size, window.btoa(e.target.result))
                    .then(res => {
                        this.props.actions.updateFileUploadProgress(acceptedFile.fileID, Math.min(parseInt(offset / acceptedFile.file.size * 100), 100))
                        if (offset < acceptedFile.file.size) {
                            reader.readAsBinaryString(acceptedFile.file.slice(offset, Math.min(offset + chunkSize, acceptedFile.file.size)));
                        }
                    });
            };
            reader.onabort = () => console.log('file reading was aborted');
            reader.onerror = () => console.log('file reading has failed');
            console.log(acceptedFile);

            reader.readAsBinaryString(acceptedFile.file.slice(offset, Math.min(offset + chunkSize, acceptedFile.file.size)));
        })
    }

    render() {
        let dropzoneRef;

        return (
            <div className="card">
                <Dropzone className="dropzone" onDrop={this.onDrop.bind(this)} ref={node => dropzoneRef = node}>
                    <p>Drop files here or click to upload.</p>
                </Dropzone>
            </div>
        );
    }
}

const mapDispatchToProps = dispatch => ({
    actions: bindActionCreators({
        addFiles,
        updateFileUploadProgress
    }, dispatch)
});

export default connect(null, mapDispatchToProps)(FileUploader);