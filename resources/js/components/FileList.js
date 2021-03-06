import React, {Component} from 'react';
import {connect} from 'react-redux';

import FileListItem from './FileListItem';
import FileSearch from './FileSearch';

class FileList extends Component {
    render() {
        return (
            <div className="card">
                <FileSearch />
                <ul>
                    {this.props.files.map(file =>
                        <FileListItem key={file.fileID} file={file}/>
                    )}
                </ul>
            </div>
        );
    }
}

const mapStateToProps = state => ({
    files: state.files
});

export default connect(mapStateToProps)(FileList);