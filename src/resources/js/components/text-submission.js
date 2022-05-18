import React from 'react';

export default function TextSubmission({ submission }) {
  return (
    <>
    { submission && (
      <div className="p-5">
        <div className="rounded-xl shadow-lg mx-auto">
          <p className="p-4">{ submission }</p>
        </div>
      </div>
    )}
    </>
  );
}
