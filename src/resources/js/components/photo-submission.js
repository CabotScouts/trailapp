import React from 'react';

export default function PhotoSubmission({ submission }) {
  return (
    <>
    { (submission.file != false) && (
      <div className="p-5">
        <a href={ submission.file } target="_blank">
          <img className="rounded-xl shadow-lg mx-auto" src={ submission.file } />
        </a>
      </div>
    )}
    </>
  );
}
