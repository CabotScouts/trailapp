import React from 'react';

export default function TextSubmission({ submission }) {
  return (
    <>
    { submission && (
      <div className="bg-white rounded-xl shadow-lg mx-auto">
        <p className="p-4">{ submission }</p>
      </div>
    )}
    </>
  );
}
