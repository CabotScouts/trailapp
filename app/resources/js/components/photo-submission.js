import React from 'react';

export default function PhotoSubmission({ submission }) {
  return (
    <>
    { (submission.upload != false) && (
      <div className="p-5">
        <a href={ submission.upload.link } target="_blank">
          <img className="rounded-xl shadow-lg mx-auto" src={ submission.upload.file } />
        </a>
      </div>
    )}
    </>
  );
}
