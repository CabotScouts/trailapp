import React from 'react';

export default function PhotoSubmission({ submission }) {
  return (
    <>
    { submission && (
      <div className="p-10">
        <a href={ submission } target="_blank">
          <img className="rounded-xl shadow-lg mx-auto" src={ submission } />
        </a>
      </div>
    )}
    </>
  );
}
