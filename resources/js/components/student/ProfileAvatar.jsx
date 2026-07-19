export default function ProfileAvatar({ profile, preview, className = 'h-24 w-24 text-2xl' }) {
    const image = preview || profile.profileImage;
    return <div className={`grid shrink-0 place-items-center overflow-hidden rounded-full border-4 border-white bg-blue-50 font-black text-[#102b70] shadow-md ${className}`}>{image ? <img src={image} alt={`${profile.firstName} ${profile.lastName}`} className="h-full w-full object-cover" /> : <span>{profile.initials}</span>}</div>;
}
