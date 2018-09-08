import React, {Component} from 'react';
import {Circle} from 'rc-progress';

export default class FileListItem extends Component {
    render() {
        console.log(this.props);
        return (
            <li>
                <a href={this.props.file.url}>{this.props.file.fileName}</a>
                {this.props.file.uploadInProgress || true
                    ? <Circle percent={this.props.file.uploadProgressPercent} strokeWidth={3}/>
                    : null}
            </li>
        );
    }
}
