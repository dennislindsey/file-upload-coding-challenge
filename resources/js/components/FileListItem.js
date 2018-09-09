import React, {Component} from 'react';
import {Circle} from 'rc-progress';

export default class FileListItem extends Component {
    render() {
        console.log(this.props);
        return (
            <li>
                {this.props.file.uploadComplete
                    ? <a href={this.props.file.url}>{this.props.file.fileName}</a>
                    : <span>{this.props.file.fileName}</span>}
                {this.props.file.uploadInProgress || true
                    ? <Circle percent={this.props.file.uploadProgressPercent} strokeWidth={3}/>
                    : null}
            </li>
        );
    }
}
